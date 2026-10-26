<?php

use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

new class extends Component {
    public bool $showModal = false;
    public string $code = '';
    public string $message = '';
    public string $messageType = '';

    public function openModal(): void
    {
        $this->showModal = true;
        $this->message = '';
        $this->code = '';

        $user = Auth::user();
        if ($user && !$user->isVerified()) {
            $this->sendCode();
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->code = '';
        $this->message = '';
    }

    public function sendCode(): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $code = $user->generateVerificationCode();
        Mail::to($user->email)->queue(new VerificationCodeMail($code));

        $this->message = 'Verification code sent to your email.';
        $this->messageType = 'success';
    }

    public function verify(): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        if (strlen($this->code) !== 4) {
            $this->message = 'Code must be 4 digits.';
            $this->messageType = 'error';
            return;
        }

        if ($user->verifyWithCode($this->code)) {
            $this->message = 'Your email has been verified successfully.';
            $this->messageType = 'success';
            $this->code = '';
            $this->showModal = false;
        } else {
            $this->message = 'Invalid or expired code.';
            $this->messageType = 'error';
        }
    }
};
?>

<div>
    @if (!auth()->user()?->isVerified())
        <button wire:click="openModal"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-amber-500 to-amber-600 text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            Not Verified
        </button>
    @endif

    @if ($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999]"
            wire:click.self="closeModal">
            <div class="relative bg-white rounded-2xl p-8 w-[90%] max-w-md shadow-2xl">
                <button wire:click="closeModal"
                    class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>

                <div
                    class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>

                <h2 class="text-center text-2xl font-bold text-gray-900 mb-2">
                    Verify Your Email
                </h2>

                <p class="text-center text-gray-500 text-sm leading-relaxed mb-6">
                    We sent a 4-digit code to<br>
                    <strong class="text-gray-900 font-semibold">{{ auth()->user()?->email }}</strong>
                </p>

                <div class="flex gap-3 justify-center mb-6" x-data="{
                    handleInput(e, index) {
                            let value = e.target.value.replace(/\D/g, '');
                            e.target.value = value.slice(-1);
                            $wire.code = Array.from(document.querySelectorAll('.code-input')).map(i => i.value).join('');
                            if (value && index < 3) {
                                document.querySelectorAll('.code-input')[index + 1].focus();
                            }
                        },
                        handleBackspace(e, index) {
                            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                                document.querySelectorAll('.code-input')[index - 1].focus();
                            }
                        },
                        handlePaste(e) {
                            e.preventDefault();
                            let paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 4);
                            let inputs = document.querySelectorAll('.code-input');
                            paste.split('').forEach((char, i) => {
                                if (inputs[i]) inputs[i].value = char;
                            });
                            $wire.code = paste;
                            if (paste.length === 4) {
                                inputs[3].focus();
                            } else if (inputs[paste.length]) {
                                inputs[paste.length].focus();
                            }
                        }
                }">
                    <input type="text"
                        class="code-input w-14 h-16 text-center text-2xl font-bold text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 focus:scale-105 focus:bg-white"
                        maxlength="1" inputmode="numeric" x-on:input="handleInput($event, 0)"
                        x-on:keydown="handleBackspace($event, 0)" x-on:paste="handlePaste($event)" autofocus>
                    <input type="text"
                        class="code-input w-14 h-16 text-center text-2xl font-bold text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 focus:scale-105 focus:bg-white"
                        maxlength="1" inputmode="numeric" x-on:input="handleInput($event, 1)"
                        x-on:keydown="handleBackspace($event, 1)" x-on:paste="handlePaste($event)">
                    <input type="text"
                        class="code-input w-14 h-16 text-center text-2xl font-bold text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 focus:scale-105 focus:bg-white"
                        maxlength="1" inputmode="numeric" x-on:input="handleInput($event, 2)"
                        x-on:keydown="handleBackspace($event, 2)" x-on:paste="handlePaste($event)">
                    <input type="text"
                        class="code-input w-14 h-16 text-center text-2xl font-bold text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 focus:scale-105 focus:bg-white"
                        maxlength="1" inputmode="numeric" x-on:input="handleInput($event, 3)"
                        x-on:keydown="handleBackspace($event, 3)" x-on:paste="handlePaste($event)">
                </div>

                @if ($message)
                    <div
                        class="p-3 rounded-lg text-sm text-center mb-4 {{ $messageType === 'success' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                        {{ $message }}
                    </div>
                @endif

                <div class="flex gap-3">
                    <button wire:click="verify"
                        class="flex-1 px-6 py-3.5 bg-gradient-to-br from-amber-500 to-amber-600 text-white font-semibold text-sm rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">
                        Verify
                    </button>
                    <button wire:click="sendCode"
                        class="flex-1 px-6 py-3.5 bg-gray-100 text-gray-700 font-semibold text-sm border border-gray-200 rounded-xl hover:bg-gray-200 transition-all hover:-translate-y-0.5">
                        Resend Code
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
