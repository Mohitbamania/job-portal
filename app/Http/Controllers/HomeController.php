<?php

namespace App\Http\Controllers;

use App\Jobs\MessageSendJob;
use App\Mail\ContactMail;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $categories = JobCategory::where('status', 1)->orderBy('name', 'ASC')->get();
        $featuredJob = Job::with('type')->where('status', 1)->orderBy('created_at', 'DESC')->where('isFeatured', 1)->get();
        $latestJob = Job::with('type')->where('status', 1)->orderBy('created_at', 'DESC')->get();

        $aiJobCount = Job::where('status', 1)->where('job_category_id', 1)->count();
        $dataScienceJobCount = Job::where('status', 1)->where('job_category_id', 2)->count();
        $cyberSecurityJobCount = Job::where('status', 1)->where('job_category_id', 3)->count();
        $cloudJobCount = Job::where('status', 1)->where('job_category_id', 4)->count();
        $healthcareJobCount = Job::where('status', 1)->where('job_category_id', 5)->count();
        $DMJobCount = Job::where('status', 1)->where('job_category_id', 6)->count();
        $constructionJobCount = Job::where('status', 1)->where('job_category_id', 7)->count();
        $financeJobCount = Job::where('status', 1)->where('job_category_id', 8)->count();

        return view('front.home', compact(
            'categories',
            'featuredJob',
            'latestJob',
            'aiJobCount',
            'dataScienceJobCount',
            'cyberSecurityJobCount',
            'cloudJobCount',
            'healthcareJobCount',
            'DMJobCount',
            'constructionJobCount',
            'financeJobCount'
        ));

    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $mailData = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        $mail = config('mail.contact_receiver');


        Dispatch(new MessageSendJob($mailData, $mail));



        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function privacyPolicy()
    {
        return view('front.account.privacy-policy');
    }

    public function termsConditions()
    {
        return view('front.account.terms-condition');
    }
}
