<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Requests\ValidateFormContactUs;
use App\Jobs\NotifayUsersPostWasCommented;
use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function create(ValidateFormContactUs $request)
    {
        $data = $request->except(['_token','submit']);
        $email = new Email();
        $myEmail = $email->create($data);

        //Mail::to(config('mail.from.address'))->queue(new ContactUs($myEmail));
        //Mail::to(config('mail.from.addrese'))->send(new ContactUs($myEmail));
        Mail::to(config('mail.from.address'))->later(now()->addMinutes(1),new ContactUs($myEmail));

        NotifayUsersPostWasCommented::dispatch($myEmail);
        return redirect()->back();
    }
}
