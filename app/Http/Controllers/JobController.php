<?php

namespace App\Http\Controllers;

use App\Jobs\CandidateApprovedJob;
use App\Jobs\CandidateRejectJob;
use App\Jobs\JobAppliedJob;
use App\Mail\ApproveCandidate;
use App\Mail\JobNotification;
use App\Mail\RejectCandidate;
use App\Models\FavouriteJob;
use App\Models\JobApplication;
use App\Models\JobSaved;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Jobs\MailSendJob;
use Session;

class JobController extends Controller
{
    public function job(Request $request)
    {
        $jobCategories = JobCategory::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        $jobs = Job::where('status', 1);

        if (!empty($request->keywords)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keywords . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keywords . '%');
            });
        }

        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        if (!empty($request->category)) {
            $jobs = $jobs->where('job_category_id', $request->category);
        }

        if (!empty($request->jobType)) {

            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        if (!empty($request->sort)) {

            if ($request->sort == 'latest') {
                $jobs = $jobs->orderBy('created_at', 'desc');
            }
            if ($request->sort == 'oldest') {
                $jobs = $jobs->orderBy('created_at', 'asc');
            }
        }

        $jobs = $jobs->paginate(12);

        return view('front.job', compact('jobCategories', 'jobTypes', 'jobs'));
    }

    public function jobOverview($id)
    {

        $job = Job::with('type')->where('id', $id)->where('status', 1)->first();
        if (!$job) {
            abort(404);
        }

        $isSaved = false;
        $isApplied = false;

        if (Auth::check()) {
            $isSaved = Auth::user()->savedJobs()->where('job_id', $job->id)->exists();
            $isApplied = Auth::user()->jobApplications()->where('job_id', $job->id)->exists();
        }
        return view('front.account.job.job-overview', compact('job', 'isSaved', 'isApplied'));
    }

    public function applyJob(Request $request)
    {

        $job = Job::where('id', $request->id)->first();
        if (!$job) {

            session()->flash('error', 'Job does not exists');

            return response()->json([

                'succcess' => false,
                'errors' => "job not found"
            ]);
        }

        $jobApplied = JobApplication::where('user_id', Auth::user()->id)->where('job_id', $request->id)->first();
        if ($jobApplied) {

            return response()->json([

                'success' => false,
                'errors' => 'You have already applied this job!'
            ]);

        }

        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            return response()->json([

                'success' => false,
                'errors' => 'You can not apply on your own job'
            ]);
        }

        $data['job_id'] = $request->id;
        $data['employer_id'] = $employer_id;
        $data['user_id'] = Auth::user()->id;
        $data['applied_date'] = now();

        JobApplication::create($data);

        $employer = User::where('id', $employer_id)->first();

        $mailData = [

            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job
        ];

        $mail = $employer->email;

        Dispatch(new JobAppliedJob($mailData, $mail));


        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }

    public function appliedJob(Request $request)
    {

        $id = Auth::user()->id;

        $appliedJob = JobApplication::with('jobDetail')->where('user_id', $id)->get();

        return view('front.account.job.applied-job', compact('appliedJob'));
    }

    public function appliedJobDelete(Request $request)
    {

        $job = JobApplication::where('user_id', Auth::user()->id)->where('id', $request->jobId)->first();

        if (!$job) {

            return response()->json([
                'success' => false,
                'errors' => 'No Applied Job Found'
            ]);
        }

        $job->delete();

        session()->flash('success', 'Applied Job has been successfully Deleted');

        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function savedJob(Request $request)
    {
        $job = Job::where('id', $request->id)->first();

        if (!$job) {
            return response()->json([
                'success' => false,
                'errors' => 'No Job Found'
            ]);
        }

        $employee_id = $job->user_id;
        if ($employee_id == Auth::user()->id) {
            return response()->json([
                'success' => false,
                'errors' => 'You cannot save your own job'
            ]);
        }


        JobSaved::create([
            'user_id' => Auth::id(),
            'job_id' => $request->id,
        ]);

        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }


    public function unSavedJob(Request $request)
    {

        $job = Job::where('id', $request->id)->first();

        if (!$job) {

            return response()->json([
                'success' => false,
                'errors' => 'No Job Found'
            ]);
        }

        JobSaved::where('job_id', $request->id)->delete();


        //session()->flash('success', 'Job has been successfully Unsaved');

        return response()->json([

            'success' => true,
            'errors' => []
        ]);
    }



    public function saveJob()
    {
        $id = Auth::user()->id;

        $saveJob = JobSaved::with('job')->where('user_id', $id)->get();

        return view('front.account.job.saved-job', compact('saveJob'));
    }

    public function deleteSavedJob(Request $request)
    {

        $id = Auth::user()->id;

        $savedJob = JobSaved::where('id', $request->id)->where('user_id', $id)->first();

        if (!$savedJob) {

            return response()->json([

                'success' => false,
                'errors' => 'Saved Job not found'
            ]);
        }

        $savedJob->delete();

        session()->flash('success', ' Saved Job has been successfully Deleted');

        return response()->json([
            'success' => true,
            'errors' => []
        ]);
    }

    public function favouriteJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $favourite = FavouriteJob::where('user_id', Auth::id())
            ->where('job_id', $request->job_id)
            ->first();

        if ($favourite) {
            // Remove if already favourite
            $favourite->delete();
            Session()->flash('success', 'Removed from favourite');
        } else {
            // Add new favourite
            FavouriteJob::create([
                'user_id' => Auth::id(),
                'job_id' => $request->job_id
            ]);
            Session()->flash('success', 'Added to favourite');
        }

        return redirect()->back();
    }

    public function candidate()
    {

        $candidates = JobApplication::where('employer_id', Auth::user()->id)->with('user', 'jobDetail')->get();

        return view('front.account.job.candidate', compact('candidates'));
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

}
