<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read setting|create setting|update setting|delete setting', ['only' => ['index','store']]);
        $this->middleware('permission:create setting', ['only' => ['create','store']]);
        $this->middleware('permission:update setting', ['only' => ['edit','update']]);
        $this->middleware('permission:delete setting', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if($request->isMethod('GET')){
            $settings = Config::get('pan');

            return view('admin.settings.index', compact('settings'));
        }

        // Validate the form data
        $validatedData = $request->validate([
            'site_name' => 'required|max:255',
            'site_slogan' => 'max:255',
            'site_logo' => 'file|mimes:png,jpg,jpeg,gif,svg',
            'phone_number' => 'required|max:20',
            'email' => 'required|email|max:255',
            'facebook' => 'url|max:255',
            'twitter' => 'url|max:255',
            'instagram' => 'url|max:255',
            'youtube' => 'url|max:255',
            'smtp_username' => 'required|max:255',
            'smtp_password' => 'required',
            'smtp_host' => 'required|max:255',
            'smtp_from_address' => 'required|email|max:255',
            'smtp_from_name' => 'required|max:255',
            'smtp_mail_port' => 'required|numeric',
            'paystack_key' => 'required|max:255',
            'extra_charge' => 'numeric',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
            'meta_keywords' => 'required|max:255',
            'sms_username' => 'required',
            'sms_sender' => 'required',
            'sms_password' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'payment_split_code' => 'nullable',
        ]);


        // Update the configuration values
        Config::set('pan.site_name', $validatedData['site_name']);
        Config::set('pan.site_slogan', $validatedData['site_slogan']);
        Config::set('pan.phone_number', $validatedData['phone_number']);
        Config::set('pan.email', $validatedData['email']);
        Config::set('pan.facebook', $validatedData['facebook']);
        Config::set('pan.twitter', $validatedData['twitter']);
        Config::set('pan.instagram', $validatedData['instagram']);
        Config::set('pan.youtube', $validatedData['youtube']);
        Config::set('pan.smtp_username', $validatedData['smtp_username']);
        Config::set('pan.smtp_password', $validatedData['smtp_password']);
        Config::set('pan.smtp_host', $validatedData['smtp_host']);
        Config::set('pan.smtp_from_address', $validatedData['smtp_from_address']);
        Config::set('pan.smtp_from_name', $validatedData['smtp_from_name']);
        Config::set('pan.smtp_mail_port', $validatedData['smtp_mail_port']);
        Config::set('pan.paystack_key', $validatedData['paystack_key']);
        Config::set('pan.paystack_secret_key', $validatedData['paystack_key']);
        Config::set('pan.extra_charge', $validatedData['extra_charge']);
        Config::set('pan.meta_title', $validatedData['meta_title']);
        Config::set('pan.sms_username', $validatedData['sms_username']);
        Config::set('pan.sms_password', $validatedData['sms_password']);
        Config::set('pan.meta_description', $validatedData['meta_description']);
        Config::set('pan.meta_keywords', $validatedData['meta_keywords']);
        Config::set('pan.sms_sender', $validatedData['sms_sender']);
        Config::set('pan.bank_name', $validatedData['bank_name']);
        Config::set('pan.account_name', $validatedData['account_name']);
        Config::set('pan.account_number', $validatedData['account_number']);
        Config::set('pan.payment_split_code', $validatedData['payment_split_code']);


        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {
            $file = $request->file('site_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('logo');
            Config::set('pan.site_logo', 'logo/'.$fileName);
            $file->move($filePath, $fileName);
        }

        // Save the updated values to the configuration file
        $configContent = '<?php return ' . var_export(config('pan'), true) . ';';
        file_put_contents(config_path('pan.php'), $configContent);

        $settings = Config::get('pan');

        return view('admin.settings.index', compact('settings'));
    }

}

//
