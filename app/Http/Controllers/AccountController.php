<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function registratioin()
    {

        return view('front.account.registration');
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'image' => 'required|image',
            'contact' => 'required|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first(),
            ], 422);
        }

        if ($request->image) {

            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('/profile_image/'), $imageName);

        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['image'] = $imageName;
        $data['mobile'] = $request->contact;

        User::create($data);

        session()->flash('success', 'You have registered successfully.');

        return response()->json([
            'status' => true,
            'errors' => [],
        ]);

    }

    public function login()
    {
        return view('front.account.login');
    }
    public function authentication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if (in_array($user->role, ['admin', 'super_admin', 'sub_admin'])) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to Admin Dashboard');
            }

            return redirect()->route('account.profile')->with('success', 'Login Successfully');
        }

        return redirect()->back()->with('error', 'Invalid Credentials');
    }


    public function profile()
    {

        $id = Auth::user()->id;

        $user = User::where('id', $id)->first();

        return view('front.account.profile', compact('user'));
    }

    public function logout()
    {

        Auth::logout();

        Session()->flash('success', 'Logout Successfully');

        return redirect()->route('account.login')->with('success', 'Logout Successfully');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users|max:255',
            'mobile' => 'required|max:10',
            'designation' => 'required',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::findOrFail($request->user_id);

        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['designation'] = $request->designation;

        if ($request->hasFile('resume')) {
            $resume = $request->file('resume');
            $fileName = 'resume_' . $user->id . '_' . time() . '.' . $resume->getClientOriginalExtension();
            $resumePath = public_path('resume');

            // create directory if not exists
            if (!file_exists($resumePath)) {
                mkdir($resumePath, 0755, true);
            }

            $resume->move($resumePath, $fileName);

            // save file path in DB (e.g. /resume/filename.pdf)
            $data['resume'] = 'resume/' . $fileName;
        }
        if ($request->email) {
            $data['email'] = $request->email;

        } else {

            $data['email'] = $user->email;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function updateProileImage(Request $request)
    {
        $id = AUth::user()->id;

        $validator = Validator::make($request->all(), [

            'image' => 'required|image',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $imageName = $id . '-' . time() . '.' . $extension;
        $image->move(public_path('/profile_image/'), $imageName);

        User::where('id', $id)->update(['image' => $imageName]);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);

    }

    public function analyzeResume(Request $request)
    {
        try {
            $request->validate([
                'resume' => 'required|mimes:pdf,doc,docx|max:2048',
            ]);

            $file = $request->file('resume');
            $text = '';

            // Extract text (basic example for PDF)
            if ($file->getClientOriginalExtension() === 'pdf') {
                $text = shell_exec('pdftotext ' . escapeshellarg($file->getPathname()) . ' -');
            } else {
                // For .doc/.docx use PhpWord or similar
                $text = file_get_contents($file->getPathname());
            }

            // Basic scoring logic (can improve later)
            $score = 0;
            $text = strtolower($text);

            Log::info('Resume Text: ' . substr($text, 0, 200));

            $keywords = ['experience', 'skills', 'education', 'project', 'certification', 'objective', 'achievement'];
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    $score += 10;
                }
            }

            // Bonus for length and structure
            $wordCount = str_word_count($text);
            if ($wordCount > 200)
                $score += 20;
            if ($wordCount > 500)
                $score += 10;

            $score = min(100, $score); // cap at 100

            return response()->json(['success' => true, 'score' => $score]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function createJob()
    {

        $jobCategories = JobCategory::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        return view('front.account.job.create', compact('jobCategories', 'jobTypes'));
    }

    public function saveJob(Request $request)
    {
        $id = AUth::user()->id;

        $validator = Validator::make($request->all(), [

            'title' => 'required|min:5|max:200',
            'category' => 'required|',
            'jobType' => 'required|',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required|',
            'experience' => 'required',
            'company_name' => 'required|min:5|max:75',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $data['user_id'] = $id;
        $data['title'] = $request->title;
        $data['job_category_id'] = $request->category;
        $data['job_type_id'] = $request->jobType;
        $data['vacancy'] = $request->vacancy;
        $data['salary'] = $request->salary;
        $data['location'] = $request->location;
        $data['description'] = $request->description;
        $data['benefits'] = $request->benefits;
        $data['responsibility'] = $request->responsibility;
        $data['qualification'] = $request->qualifications;
        $data['keywords'] = $request->keywords;
        $data['experience'] = $request->experience;
        $data['company_name'] = $request->company_name;
        $data['company_location'] = $request->company_location;
        $data['company_website'] = $request->website;

        Job::create($data);

        //session()->flash('success', 'Job has been successully Added');

        return response()->json([
            'success' => true,
            'errors' => []
        ]);

    }

    public function myJob()
    {
        $myJobs = Job::where('user_id', Auth::id())
            ->with('type')
            ->withCount('applications') // 👈 counts related applications
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $jobApplicants = JobApplication::where('employer_id', Auth::id())
            ->with('jobDetail')
            ->count();

        return view('front.account.job.my-job', compact('myJobs', 'jobApplicants'));
    }

    public function editJob(Request $request, $id)
    {
        $jobCategories = JobCategory::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        $job = Job::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if (!$job) {
            abort(404);
        }
        return view('front.account.job.edit', compact('jobCategories', 'jobTypes', 'job'));
    }

    public function updateJob(Request $request)
    {
        $id = AUth::user()->id;

        $validator = Validator::make($request->all(), [
            'edit_job_id' => 'required',
            'title' => 'required|min:5|max:200',
            'category' => 'required|',
            'jobType' => 'required|',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required|',
            'experience' => 'required',
            'company_name' => 'required|min:5|max:75',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $job = Job::findOrFail($request->edit_job_id);
        if (!$job) {

            return response()->json([
                'success' => false,
                'errors' => 'No Job Found'
            ]);
        }

        $data['user_id'] = $id;
        $data['title'] = $request->title;
        $data['job_category_id'] = $request->category;
        $data['job_type_id'] = $request->jobType;
        $data['vacancy'] = $request->vacancy;
        $data['salary'] = $request->salary;
        $data['location'] = $request->location;
        $data['description'] = $request->description;
        $data['benefits'] = $request->benefits;
        $data['responsibility'] = $request->responsibility;
        $data['qualification'] = $request->qualifications;
        $data['keywords'] = $request->keywords;
        $data['experience'] = $request->experience;
        $data['company_name'] = $request->company_name;
        $data['company_location'] = $request->company_location;
        $data['company_website'] = $request->website;

        $job->update($data);

        //session()->flash('success', 'Job has been successully Updated');

        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }
    public function deleteJob(Request $request)
    {

        $job = Job::where('user_id', Auth::user()->id)->where('id', $request->job_id)->first();

        if (!$job) {

            return response()->json([
                'success' => false,
                'errors' => 'No Job Found'
            ]);
        }

        $job->delete();

        //session()->flash('success', 'Job has been successfully Deleted');

        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($request->old_password, $user->password) == false) {

            session()->flash('error', 'Your old password is Incorrect');
        }


        $user = User::findOrFail(Auth::user()->id);

        $data['password'] = bcrypt($request->password);

        User::where('id', $user->id)->update($data);
        session()->flash('success', 'Your password has been changed');

        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }

    public function forgotPassword()
    {

        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withInputs($validator)->withInput();
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([

            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);


        $user = User::where('email', $request->email)->first();

        $mailData = [

            'token' => $token,
            'user' => $user
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        Session()->flash('info', 'We have mailed your password reset link!');

        return redirect()->route('account.login');
    }

    public function resetPassword($tokenString)
    {

        $tokenData = DB::table('password_reset_tokens')->where('token', $tokenString)->first();

        if (!$tokenData) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid Token');
        }

        return view('front.account.reset-password', compact('tokenString'));

    }

    public function processResetPassword(Request $request)
    {

        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$tokenData) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid Token');
        }

        $validator = Validator::make($request->all(), [

            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {

            return redirect()->route('account.resetPassword', $request->token)->withErrors($validator)->withInput();
        }

        User::where('email', $tokenData->email)->update(['password' => bcrypt($request->new_password)]);

        return redirect()->route('account.login')->with('success', 'Your password has been changed');

    }


}
