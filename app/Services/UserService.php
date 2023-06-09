<?php

namespace App\Services;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PdfFile;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPdfFile;

class UserService
{
    public function store(array $data): User
    {
        return User::create($data);
    }

    public function login(array $credentials): ?Authenticatable
    {
        if (Auth::attempt($credentials)) {
            return auth()->user();
        }

        return null;
    }

    public function forgotPassword(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $data): mixed
    {
        return Password::reset($data, function ($user) use ($data) {
            $user->forceFill(['password' => $data['password']])->save();
        });
    }

    public function update(User $user, array $data): User
    {
        $user->fill($data)->save();
        return $user;
    }

    public function getEmailsList(): array
    {
        return User::all()->pluck('email')->toArray();
    }

    public function delete(User $user): ?bool
    {
        $pdf = $this->generatePdfFile();
        Mail::to($user->email)->send(new SendPdfFile($pdf->output()));

        return $user->delete();
    }

    public function generatePdfFile(): PdfFile
    {
        return Pdf::loadView('emails.report');
    }
}
