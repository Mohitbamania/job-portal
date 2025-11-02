<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobSaved;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobNotification;
use App\Mail\ApproveCandidate;
use App\Mail\RejectCandidate;

class UserConroller extends Controller
{

    public function createJob(Request $request)
    {
        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [

                'title' => 'required|min:5|max:200',
                'category_id' => 'required|',
                'jobType_id' => 'required|',
                'vacancy' => 'required|integer',
                'salary' => 'nullable|string',
                'location' => 'required|max:50',
                'description' => 'required|',
                'benefits' => 'nullable|string',
                'responsibilities' => 'nullable|string',
                'qualification' => 'nullable|string',
                'keywords' => 'nullable|string',
                'experience' => 'required',
                'company_name' => 'required|min:5|max:75',
                'company_location' => 'nullable|max:100',
                'company_website' => 'nullable|url',

            ]);

            if ($validator->fails()) {

                return response()->josn([

                    'status' => 422,
                    'error' => $validator->errors()
                ], 422);
            }

            $data['user_id'] = $user->id;
            $data['title'] = $request->title;
            $data['job_category_id'] = $request->category_id;
            $data['job_type_id'] = $request->jobType_id;
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

            $job = Job::create($data);

            return response()->json([

                'status' => 200,
                'message' => 'User Job Created Successfully',
                'job_id' => $job->id
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => 500,
                'message' => 'Error ocured while creating job',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function updateJob(Request $request)
    {
        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [

                'job_id' => 'nullable|integer',
                'title' => 'nullable|min:5|max:200',
                'category_id' => 'nullable|',
                'jobType_id' => 'nullable|',
                'vacancy' => 'nullable|integer',
                'salary' => 'nullable|string',
                'location' => 'nullable|max:50',
                'description' => 'nullable|',
                'benefits' => 'nullable|string',
                'responsibilities' => 'nullable|string',
                'qualification' => 'nullable|string',
                'keywords' => 'nullable|string',
                'experience' => 'nullable',
                'company_name' => 'nullable|min:5|max:75',
                'company_location' => 'nullable|max:100',
                'company_website' => 'nullable|url',

            ]);

            if ($validator->fails()) {

                return response()->josn([

                    'status' => 422,
                    'error' => $validator->errors()
                ], 422);
            }

            $job = Job::find($request->job_id);
            if (!$job) {
                return response()->json([

                    'status' => 404,
                    'message' => 'Job not found'
                ], 404);
            }

            $data['user_id'] = $user->id;
            $data['title'] = $request->title ?? $job->title;
            $data['job_category_id'] = $request->category_id ?? $job->job_category_id;
            $data['job_type_id'] = $request->jobType_id ?? $job->job_type_id;
            $data['vacancy'] = $request->vacancy ?? $job->vacancy;
            $data['salary'] = $request->salary ?? $job->salary;
            $data['location'] = $request->location ?? $job->location;
            $data['description'] = $request->description ?? $job->description;
            $data['benefits'] = $request->benefits ?? $job->benefits;
            $data['responsibility'] = $request->responsibility ?? $job->responsibility;
            $data['qualification'] = $request->qualification ?? $job->qualification;
            $data['keywords'] = $request->keywords ?? $job->keywords;
            $data['experience'] = $request->experience ?? $job->experience;
            $data['company_name'] = $request->company_name ?? $job->company_name;
            $data['company_location'] = $request->company_location ?? $job->company_location;
            $data['company_website'] = $request->company_website ?? $job->company_website;

            $job->update($data);

            return response()->json([

                'status' => 200,
                'message' => 'User Job Updated Successfully',
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => 500,
                'message' => 'Error ocured while updating job',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth('api')->user();

            if (!$user) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized User',
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|unique:users,email,' . $user->id,
                'mobile' => 'required|max:10',
                'designation' => 'required|string',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $data['name'] = $request->name ?? $user->name;
            $data['mobile'] = $request->mobile ?? $user->mobile;
            $data['designation'] = $request->designation ?? $user->designation;
            $data['email'] = $request->email ?? $user->email;

            if ($request->hasFile('resume')) {
                $resume = $request->file('resume');
                $fileName = 'resume_' . $user->id . '_' . time() . '.' . $resume->getClientOriginalExtension();
                $resumePath = public_path('resume');

                if (!file_exists($resumePath)) {
                    mkdir($resumePath, 0755, true);
                }

                $resume->move($resumePath, $fileName);
                $data['resume'] = 'resume/' . $fileName;
            } else {
                $data['resume'] = $user->resume;
            }

            $user->update($data);

            return response()->json([
                'status' => 200,
                'message' => 'User Profile Updated Successfully',
                'data' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while updating user profile',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getMyJob(Request $request)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $userJobs = Job::where('user_id', $user->id)
                ->with(['user', 'category', 'type'])
                ->where('status', 1)
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Job Fetched Successfully',
                'data' => $userJobs

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while fetching data',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getMyAppliedJob(Request $request)
    {

        try {
            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $appliedJob = JobApplication::where('user_id', $user->id)
                ->with([
                    'user',
                    'employe',
                    'jobDetail.category',
                    'jobDetail.type',
                    'jobDetail.user'
                ])
                ->get();

            return response()->json([

                'status' => 200,
                'message' => 'User Applied Job Fetched Successfully',
                'data' => $appliedJob
            ], 200);


        } catch (\Exception $e) {


            return response()->json([


                'status' => 500,
                'message' => 'Error ocured while fetching data',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function getMySavedJob(Request $request)
    {

        try {
            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }


            $savedJob = JobSaved::where('user_id', $user->id)->with(['user', 'job.category', 'job.type', 'job.user'])->where('status', 1)->get();

            return response()->json([

                'status' => 200,
                'message' => 'User Saved Job Fetched Successfully',
                'data' => $savedJob
            ], 200);


        } catch (\Exception $e) {


            return response()->json([


                'status' => 500,
                'message' => 'Error ocured while fetching data',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getJobDetailsById(Request $request)
    {
        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'job_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $job = Job::with(['user', 'category', 'type'])
                ->where('id', $request->job_id)
                ->where('status', 1)
                ->first();

            if (!$job) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Job not found',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Job Details Fetched Successfully',
                'data' => $job,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while fetching job details',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function appliyJob(Request $request)
    {

        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'job_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $job = Job::where('id', $request->job_id)
                ->first();

            if (!$job) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Job not found',
                ], 404);
            }

            $jobApplied = JobApplication::where('user_id', $user->id)->where('job_id', $request->job_id)->first();
            if ($jobApplied) {

                return response()->json([
                    'status' => 409,
                    'message' => 'You have already applied for this job',
                ]);

            }

            $employer_id = $job->user_id;

            if ($employer_id == $user->id) {
                return response()->json([

                    'status' => 403,
                    'message' => 'You cannot apply to your own job',
                ]);
            }

            $data['job_id'] = $request->job_id;
            $data['employer_id'] = $employer_id;
            $data['user_id'] = $user->id;
            $data['applied_date'] = now();

            JobApplication::create($data);

            $employer = User::where('id', $employer_id)->first();

            $mailData = [

                'employer' => $employer,
                'user' => $user,
                'job' => $job
            ];

            Mail::to($employer->email)->send(new JobNotification($mailData));

            return response()->json([
                'status' => 200,
                'message' => 'Job Applied Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while applying job',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function saveJob(Request $request)
    {
        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'job_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $job = Job::where('id', $request->job_id)
                ->first();

            if (!$job) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Job not found',
                ], 404);
            }

            $employee_id = $job->user_id;
            if ($employee_id == $user->id) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You cannot save your own job',
                ]);
            }

            $SavedJob = JobSaved::where('user_id', $user->id)->where('job_id', $request->job_id)->first();

            if ($SavedJob) {

                return response()->json([

                    'status' => 409,
                    'message' => 'You have already saved this job',
                ]);
            }

            JobSaved::create([
                'user_id' => $user->id,
                'job_id' => $request->job_id,
            ]);

            return response()->json([

                'status' => 200,
                'message' => 'Job Saved Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while save job',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function unSaveJob(Request $request)
    {

        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'job_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $job = Job::where('id', $request->job_id)
                ->first();

            if (!$job) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Job not found',
                ], 404);
            }

            $unsaveJob = JobSaved::where('user_id', $user->id)->where('job_id', $request->job_id)->first();
            if (!$unsaveJob) {

                return response()->json([

                    'status' => 409,
                    'message' => 'You have not saved this job',
                ]);
            }

            JobSaved::where('job_id', $request->job_id)->delete();

            return response()->json([

                'status' => 200,
                'message' => 'Job unsave Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while save job',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function approveCandidate(Request $request)
    {
        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'job_application_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $jobApplication = JobApplication::where('id', $request->job_application_id)
                ->with(['user', 'employe', 'jobDetail'])->first();

            if (!$jobApplication) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Job Application not found',
                ], 404);
            }

            $mailData = [

                'candidate' => $jobApplication->user->name,
                'employer' => $jobApplication->employe->name,
                'job' => $jobApplication->jobDetail->title,
                'interview_date' => '2025-09-20',
                'interview_time' => '10:30 AM',
                'interview_mode' => 'Google Meet (link will be shared)',
            ];

            Mail::to($jobApplication->user->email)->send(new ApproveCandidate($mailData));


            $jobApplication->update(['status' => 'Approved']);

            return response()->json([

                'status' => 200,
                'message' => 'Candidate Approved Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while approving candidate',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function rejectCandidate(Request $request)
    {
        try {

            $user = Auth('api')->user();

            if (!$user) {

                return response()->json([

                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'job_application_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $jobApplication = JobApplication::where('id', $request->job_application_id)
                ->with(['user', 'employe', 'jobDetail'])->first();

            if (!$jobApplication) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Job Application not found',
                ], 404);
            }

            $mailData = [

                'candidate' => $jobApplication->user->name,
                'employer' => $jobApplication->employe->name,
                'job' => $jobApplication->jobDetail->title,
            ];

            Mail::to($jobApplication->user->email)->send(new RejectCandidate($mailData));


            $jobApplication->update(['status' => 'Rejected']);

            return response()->json([

                'status' => 200,
                'message' => 'Candidate Rejected Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while rejecting candidate',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function searchJob(Request $request)
    {
        try {
            $user = Auth('api')->user();

            if (!$user) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized User'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'keywords' => 'nullable|string',
                'location' => 'nullable|string',
                'category_id' => 'nullable|integer',
                'jobType_id' => 'nullable|integer',
                'experience' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validator->errors(),
                ], 422);
            }

            $jobQuery = Job::with(['category', 'type', 'user']);

            if ($request->filled('keywords')) {
                $jobQuery->where(function ($q) use ($request) {
                    $q->Where('keywords', 'like', '%' . $request->keywords . '%');  
                });
            }

            if ($request->filled('location')) {
                $jobQuery->where('location', $request->location);
            }

            if ($request->filled('category_id')) {
                $jobQuery->where('job_category_id', $request->category_id);
            }

            if ($request->filled('jobType_id')) {
                $jobQuery->where('job_type_id', $request->jobType_id);
            }

            if ($request->filled('experience')) {
                $jobQuery->where('experience', $request->experience);
            }

            $jobs = $jobQuery->get();

            if ($jobs->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No jobs found',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Jobs fetched successfully',
                'data' => $jobs,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error occurred while fetching job',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
