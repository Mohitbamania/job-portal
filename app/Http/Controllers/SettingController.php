<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Session;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();
        return view('admin.setting.setting', compact('settings'));
    }

    public function update(Request $request, string $type)
    {
        switch ($type) {
            case 'general':
                Setting::set('site_title', $request->site_title);
                Setting::set('contact_email', $request->contact_email);

                if ($request->hasFile('logo')) {
                    $path = $request->file('logo')->store('logos', 'public');
                    Setting::set('logo', $path);
                }
                break;

            case 'seo':
                Setting::set('meta_title', $request->meta_title);
                Setting::set('meta_description', $request->meta_description);
                break;

            case 'payment':
                Setting::set('currency', $request->currency);
                Setting::set('payment_gateway', $request->payment_gateway);
                break;

            case 'notifications':
                Setting::set('admin_email', $request->admin_email);
                Setting::set('job_alerts', $request->job_alerts);
                break;

            case 'security':
                Setting::set('two_factor', $request->two_factor);
                Setting::set('max_login_attempts', $request->max_login_attempts);
                break;

            default:
                return redirect()->back()->with('error', 'Invalid settings type');
        }

        Session()->flash('success', ucfirst($type) . ' settings updated successfully!');

        return redirect()->back()->with('success', ucfirst($type) . ' settings updated successfully!');
    }
}
