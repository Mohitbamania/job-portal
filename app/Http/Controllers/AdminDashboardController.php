<?php

namespace App\Http\Controllers;

use App\Jobs\CandidateApprovedJob;
use App\Jobs\CandidateRejectJob;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use App\HttControllers\Controler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Mail\ApproveCandidate;
use App\Mail\RejectCandidate;
use Illuminate\Support\Facades\Mail;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::where('role', 'user')->count();
        $jobsCount = Job::where('status', 1)->count();
        $jobApplicationsCount = JobApplication::count();
        $users = User::where('role', 'user')->get();
        $jobApplication = JobApplication::with('user')->with('employe')->get();

        // Get user registrations per month (last 6 months)
        $userGrowth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Prepare labels (Jan, Feb, etc.) and values
        $labels = [];
        $values = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = date('M', mktime(0, 0, 0, $m, 1));
            $values[] = $userGrowth[$m] ?? 0;
        }

        return view('admin.dashboard', compact(
            'usersCount',
            'jobsCount',
            'jobApplicationsCount',
            'labels',
            'values',
            'users',
            'jobApplication'
        ));
    }


    public function userList()
    {

        $users = User::orderBy('created_at', 'ASC')->where('role', 'user')->paginate(10);

        return view('admin.user.user-list', compact('users'));
    }

    public function addUser()
    {

        return view('admin.user.add-user');
    }

    public function userStore(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);

        User::create($data);


        return response()->json([
            'status' => true,   // ✅ consistent
            'errors' => []
        ]);
    }

    public function userEdit($id)
    {

        $user = User::findOrFail($id);

        return view('admin.user.edit-user', compact('user'));
    }

    public function userUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->edit_user_id,
            'mobile' => 'required|max:10',
            'designation' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::findOrFail($request->edit_user_id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'designation' => $request->designation,
        ]);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }
    public function userDelete(Request $request)
    {
        $user = User::FindOrFail($request->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        $user->delete();


        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }

    public function jobCategoryList()
    {

        $jobCategories = JobCategory::orderBy('created_at', 'ASC')->where('status', 1)->paginate();

        return view('admin.job_category.job-category-list', compact('jobCategories'));
    }

    public function addJobCategory()
    {

        return view('admin.job_category.add-job-category');
    }

    public function jobCategoryStore(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }


        $data['name'] = $request->name;

        JobCategory::create($data);


        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    public function jobCategoryEdit($id)
    {

        $jobCategory = JobCategory::findOrFail($id);

        return view('admin.job_category.edit-job-category', compact('jobCategory'));
    }

    public function jobCategoryUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_job_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }

        $jobCategory = JobCategory::findOrFail($request->edit_job_category_id);

        $jobCategory->update([
            'name' => $request->name,
        ]);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function jobCategoryDelete(Request $request)
    {
        $jobCategoy = JobCategory::FindOrFail($request->job_category_id);

        if (!$jobCategoy) {
            return response()->json([
                'success' => false,
                'message' => 'Job Category not found'
            ]);
        }

        $jobCategoy->delete();


        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }

    public function jobTypeList()
    {

        $jobTypes = JobType::orderBy('created_at', 'ASC')->where('status', 1)->paginate();

        return view('admin.job_type.job-type-list', compact('jobTypes'));
    }

    public function addJobType()
    {

        return view('admin.job_type.add-job-type');
    }

    public function jobTypeStore(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }

        $data['name'] = $request->name;

        JobType::create($data);


        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    public function jobTypeEdit($id)
    {

        $jobType = JobType::findOrFail($id);

        return view('admin.job_type.edit-job-type', compact('jobType'));
    }

    public function jobTypeUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_job_type_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }

        $jobType = JobType::findOrFail($request->edit_job_type_id);

        $jobType->update([
            'name' => $request->name,
        ]);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function jobTypeDelete(Request $request)
    {
        $jobType = JobType::FindOrFail($request->job_type_id);

        if (!$jobType) {
            return response()->json([
                'success' => false,
                'message' => 'Job Type not found'
            ]);
        }

        $jobType->delete();


        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }


    public function jobApplicationList()
    {

        $jobApplications = JobApplication::orderBy('created_at', 'ASC')->with('user')->with('employe')->paginate();

        return view('admin.job_application.job-application-list', compact('jobApplications'));
    }

    public function addJobApplication()
    {

        $jobs = Job::where('status', 1)->get();
        $users = User::where('role', 'user')->get();
        $employes = User::where('role', 'user')->get();

        return view('admin.job_application.add-job-application', compact('jobs', 'users', 'employes'));
    }

    public function jobApplicationStore(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'job' => 'required|string|max:255',
            'user' => 'required|string|max:255',
            'employe' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }
        $data['job_id'] = $request->job;
        $data['user_id'] = $request->user;
        $data['employer_id'] = $request->employe;
        $data['applied_date'] = now();

        JobApplication::create($data);

        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    public function jobApplicationEdit($id)
    {

        $jobApplication = JobApplication::findOrFail($id);
        $jobs = Job::where('status', 1)->get();
        $users = User::where('role', 'user')->get();
        $employes = User::where('role', 'user')->get();

        return view('admin.job_application.edit-job-application', compact('jobApplication', 'jobs', 'users', 'employes'));
    }

    public function jobApplicationUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_job_application_id' => 'required|integer',
            'job' => 'required|string|max:255',
            'user' => 'required|string|max:255',
            'employe' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }

        $jobApplication = JobApplication::findOrFail($request->edit_job_application_id);

        $jobApplication->update([
            'job_id' => $request->job,
            'user_id' => $request->user,
            'employer_id' => $request->employe,
            'applied_date' => now(),
        ]);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function jobApplicationDelete(Request $request)
    {
        $jobApplication = JobApplication::FindOrFail($request->job_application_id);

        if (!$jobApplication) {
            return response()->json([
                'success' => false,
                'message' => 'Job Application not found'
            ]);
        }

        $jobApplication->delete();


        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }

    public function approveCandidate(Request $request)
    {

        $jobApplication = JobApplication::where('id', $request->job_application_id)->with('jobDetail', 'user', 'employe')->first();

        if (!$jobApplication) {

            return response()->json([

                'success' => false,
                'message' => 'Job Application not found'
            ]);
        }

        $mailData = [

            'candidate' => $jobApplication->user->name,
            'employer' => $jobApplication->employe->name,
            'job' => $jobApplication->jobDetail->title,
            'interview_date' => '2025-09-20',
            'interview_time' => '10:30 AM',
            'interview_mode' => 'Google Meet (link will be shared)',
        ];

        $mail = $jobApplication->user->email;

        Dispatch(new CandidateApprovedJob($mailData, $mail));


        $jobApplication->update(['status' => 'Approved']);

        return response()->json([
            'success' => true,
            'message' => 'Candidate approved and email sent successfully.'
        ]);
    }

    public function rejectCandidate(Request $request)
    {
        $jobApplication = JobApplication::where('id', $request->job_application_id)->with('jobDetail', 'user', 'employe')->first();

        if (!$jobApplication) {

            return response()->json([

                'success' => false,
                'message' => 'Job Application not found'
            ]);
        }

        $mailData = [

            'candidate' => $jobApplication->user->name,
            'employer' => $jobApplication->employe->name,
            'job' => $jobApplication->jobDetail->title,
        ];

        $mail = $jobApplication->user->email;

        Dispatch(new CandidateRejectJob($mailData, $mail));


        $jobApplication->update(['status' => 'Rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Candidate rejected and email sent successfully.'
        ]);

    }

    public function jobList()
    {
        $jobs = Job::where('status', 1)->with('user')->get();

        return view('admin.job.job', compact('jobs'));
    }

    public function addJob()
    {

        $jobCategories = JobCategory::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $users = User::where('role', 'user')->get();

        return view('admin.job.add-job', compact('jobCategories', 'jobTypes', 'users'));
    }

    public function generateJobDescription(Request $request)
    {
        $title = $request->title;
        $category = $request->category;
        $jobType = $request->jobType;
        $vacancy = $request->vacancy;
        $salary = $request->salary;

        $promptText = "Write a detailed, professional job description for a '$title' in '$category' category, 
                   job type '$jobType', with $vacancy vacancies and salary $salary.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GEMINI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta2/models/text-bison-001:generate', [
                        'prompt' => [
                            'text' => $promptText
                        ],
                        'temperature' => 0.7,
                        'maxOutputTokens' => 300
                    ]);

            $data = $response->json();

            dd($data);

            // Correct path to generated text
            $description = $data['candidates'][0]['output'] ?? '';

            return response()->json([
                'success' => true,
                'description' => $description
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }



    public function jobStore(Request $request)
    {


        $validator = Validator::make($request->all(), [

            'title' => 'required|min:5|max:200',
            'category' => 'required|',
            'jobType' => 'required|',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required|',
            'user' => 'required',
            'company_name' => 'required|min:5|max:75',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $data['user_id'] = $request->user;
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
        $data['isFeatured'] = $request->is_featured ? 1 : 0;

        Job::create($data);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);

    }

    public function jobEdit(Request $request, $id)
    {
        $jobCategories = JobCategory::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $users = User::where('role', 'user')->get();

        $job = Job::where('id', $id)->first();
        if (!$job) {
            abort(404);
        }
        return view('admin.job.edit-job', compact('jobCategories', 'jobTypes', 'job', 'users'));
    }

    public function jobUpdate(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'edit_job_id' => 'required',
            'title' => 'required|min:5|max:200',
            'category' => 'required|',
            'jobType' => 'required|',
            'vacancy' => 'required|integer',
            'user' => 'required',
            'location' => 'required|max:50',
            'description' => 'required|',
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

        $data['user_id'] = $request->user;
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
        $data['isFeatured'] = $request->is_featured ? 1 : 0;

        $job->update($data);


        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }
    public function jobDelete(Request $request)
    {

        $job = Job::where('id', $request->job_id)->first();

        if (!$job) {

            return response()->json([
                'success' => false,
                'errors' => 'No Job Found'
            ]);
        }

        $job->delete();


        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function adminRoles()
    {


        $admins = User::whereIn('role', ['admin', 'super_admin', 'sub_admin'])->get();

        return view('admin.admin_role.admin_list', compact('admins'));

    }

    public function addAdmin()
    {

        return view('admin.admin_role.admin_add');
    }

    public function adminStore(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'designation' => 'required',
            'mobile' => 'required|max:10',
            'role' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }

        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $extension;
        $image->move(public_path('/profile_image/'), $imageName);


        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['designation'] = $request->designation;
        $data['mobile'] = $request->mobile;
        $data['role'] = $request->role;
        $data['image'] = $imageName;
        $data['page_permission'] = $request->menu_permissions ? json_encode($request->menu_permissions) : null;

        User::create($data);

        return response()->json([
            'status' => true,
            'errors' => [],
        ]);

    }

    public function adminEdit(Request $request, $id)
    {

        $admins = User::findOrFail($id);

        return view('admin.admin_role.admin_edit', compact('admins'));
    }

    public function adminUpdate(Request $request)
    {
        //dd($request->image);
        $validator = Validator::make($request->all(), [
            'edit_admin_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->edit_admin_id,
            'designation' => 'required',
            'mobile' => 'required|max:10',
            'role' => 'required',
            'image' => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); // no 422
        }

        $admins = User::findOrFail($request->edit_admin_id);

        if ($request->image) {

            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('/profile_image/'), $imageName);
            $data['image'] = $imageName;
        } else {

            $data['image'] = $admins->image;
        }


        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['designation'] = $request->designation;
        $data['mobile'] = $request->mobile;
        $data['role'] = $request->role;
        $data['page_permission'] = $request->page_permission ? json_encode($request->page_permission) : null;
        $admins->update($data);
        return response()->json([
            'status' => true,   // ✅ instead of "success"
            'errors' => []
        ]);
    }

    public function adminDelete(Request $request)
    {
        $user = User::FindOrFail($request->admin_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ]);
        }

        $user->delete();


        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }

    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->admin_id,
            'mobile' => 'required',
            'image' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $admin = User::findOrFail($request->admin_id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'errors' => 'No Admin Found'
            ]);
        }

        if ($request->image) {

            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('/profile_image/'), $imageName);
            $data['image'] = $imageName;
        } else {

            $data['image'] = $admin->image;
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;


        return response()->json(['success' => true, 'errors' => []]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::findOrFail($request->admin_id);

        if (Hash::check($request->current_password, $user->password) == false) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'current_password' => ['Current password is incorrect.']
                ],
            ], 400);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ], 200);
    }

}
