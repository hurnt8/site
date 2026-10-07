<?php

namespace App\Http\Controllers;

use App\Mail\LoanMail;
use App\Mail\LoanConfirmationMail;
use App\Models\Currency;
use App\Models\LoanSetting;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class LoanController extends Controller
{
    public function __construct(private LoanService $loanService) {}

    public function simulate(Request $request)
    {
        $validated = $request->validate([
            'amount'        => 'required|numeric|min:1',
            'duration'      => 'required|integer|min:1',
            'interest_rate' => 'required|numeric|min:0',
        ]);

        $monthlyPayment = $this->loanService->calculateMonthlyPayment(
            (float) $validated['amount'],
            (int)   $validated['duration'],
            (float) $validated['interest_rate']
        );

        $amortizationSchedule = $this->loanService->generateAmortizationSchedule(
            (float) $validated['amount'],
            (int)   $validated['duration'],
            (float) $validated['interest_rate'],
            $monthlyPayment
        );

        return view('simulate', [
            'loan'                 => (object) $validated,
            'monthlyPayment'       => $monthlyPayment,
            'amortizationSchedule' => $amortizationSchedule,
        ]);
    }

    public function sendMail(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'required|string|max:50',
            'country'  => 'required|string|max:100',
            'amount'   => 'required|numeric|min:1',
            'darly'    => 'required|numeric|min:1',
            'subject'  => 'required|string',
            'objet'    => 'nullable|string|max:2000',
            'currency' => 'nullable|string|in:' . implode(',', Currency::codes()),
        ]);
        $data['currency'] = $data['currency'] ?? Currency::default();

        $locale = $request->input('locale', 'fr');
        if (!in_array($locale, \App\Models\Language::enabledCodes(), true)) {
            $locale = 'fr';
        }
        App::setLocale($locale);

        // Email 1 : nouvelle demande → adresse de notification configurée
        Mail::to(LoanSetting::current()->notification_email)->send(new LoanMail($data, $locale));

        // Email 2 : confirmation → demandeur 
        Mail::to($data['email'])->send(new LoanConfirmationMail($data, $locale));

        return redirect()->route('loan', ['locale' => $locale])
            ->with('success', __('message.success_loan'));
    }
}
