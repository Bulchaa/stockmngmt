<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Yero Printing</title>
    <meta name="description" content="Sign in to the Yero Printing dashboard.">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Pacifico&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        script: ['Pacifico', 'cursive']
                    },
                    animation: {
                        'float': 'float 5s ease-in-out infinite',
                        'float-slow': 'float 7s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            overflow-x: hidden;
        }

        .gradient-text {
            background: linear-gradient(90deg, #f97316, #ec4899, #8b5cf6, #06b6d4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-gradient {
            background:
                radial-gradient(circle at 15% 20%, rgba(249,115,22,.20), transparent 28%),
                radial-gradient(circle at 80% 15%, rgba(236,72,153,.20), transparent 30%),
                radial-gradient(circle at 70% 80%, rgba(6,182,212,.18), transparent 28%),
                #fff;
        }

        .glass {
            background: rgba(255,255,255,.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(1px);
            opacity: .65;
            pointer-events: none;
        }

        .field-icon {
            transition: color .2s ease;
        }
    </style>
</head>

<body class="font-sans min-h-screen grid lg:grid-cols-2 bg-[#0f1115]">

    <!-- ========================================================= -->
    <!-- LEFT BRAND PANEL (desktop only)                          -->
    <!-- ========================================================= -->

    <div class="hidden lg:flex flex-col justify-between relative overflow-hidden hero-gradient p-10 xl:p-16">

        <!-- Decorative blobs -->
        <div class="blob w-72 h-72 bg-orange-200 -top-16 -left-16 animate-float"></div>
        <div class="blob w-80 h-80 bg-pink-200 top-32 right-[-110px] animate-float-slow"></div>
        <div class="blob w-72 h-72 bg-cyan-200 bottom-[-90px] left-[30%]"></div>

        <!-- Logo -->
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl
                        bg-gradient-to-br from-orange-500 via-pink-500 to-purple-600
                        flex items-center justify-center text-white shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 8h4l2-3h6l2 3h4v11H3V8z"/>
                    <circle cx="12" cy="13" r="3"/>
                </svg>
            </div>
            <div>
                <div class="font-black text-2xl tracking-tight">
                    Yero<span class="text-pink-500">.</span>
                </div>
                <div class="text-[10px] uppercase tracking-[.2em] text-slate-500">
                    Printing &amp; Studio
                </div>
            </div>
        </div>

        <!-- Headline -->
        <div class="relative z-10 max-w-lg">
            <div class="inline-flex items-center gap-2 px-4 py-2
                        rounded-full bg-white shadow-sm border border-slate-100
                        text-sm font-semibold mb-7">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                Creative Studio in Chiro, Ethiopia
            </div>

            <h1 class="text-5xl xl:text-6xl font-black leading-[1.05] tracking-tight">
            We print
            <span class="gradient-text"> ideas.</span>
            </h1>

            <p class="mt-6 text-lg text-slate-600 leading-8 max-w-md">
                Manage orders, print jobs, products and payments — all from one
                beautiful dashboard.
            </p>

            <!-- Feature list -->
            <ul class="mt-10 space-y-4 text-slate-700 font-medium">
                <li class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </span>
                    Order, print job &amp; payment management
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-2-5h.01M14 11h.01M16 21h4l-1-3-2 2m-2 2h-4a2 2 0 00-2-2H5a2 2 0 01-2-2V9a2 2 0 012-2h3m12 0h3a2 2 0 012 2v4a2 2 0 01-2 2"/>
                        </svg>
                    </span>
                    Automatic Telebirr payment verification
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    Instant printable receipts &amp; labels
                </li>
            </ul>

            <!-- Mini stats -->
            <div class="mt-10 flex flex-wrap gap-8">
                <div>
                    <div class="text-3xl font-black">Fast</div>
                    <div class="text-sm text-slate-500">Service</div>
                </div>
                <div>
                    <div class="text-3xl font-black">100%</div>
                    <div class="text-sm text-slate-500">Focus</div>
                </div>
                <div>
                    <div class="text-3xl font-black">Local</div>
                    <div class="text-sm text-slate-500">Chiro Based</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="relative z-10 text-sm text-slate-500">
            &copy; <?php echo date('Y'); ?> Yero Printing &middot; Photography &bull; Printing &bull; Design
        </p>
    </div>


    <!-- ========================================================= -->
    <!-- RIGHT LOGIN CARD                                         -->
    <!-- ========================================================= -->

    <div class="flex items-center justify-center p-6 sm:p-10 xl:p-16 bg-[#0f1115]">
        <div class="w-full max-w-md">

            <!-- Mobile logo -->
            <div class="lg:hidden flex items-center gap-3 mb-10">
                <div class="w-12 h-12 rounded-2xl
                            bg-gradient-to-br from-orange-500 via-pink-500 to-purple-600
                            flex items-center justify-center text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 8h4l2-3h6l2 3h4v11H3V8z"/>
                        <circle cx="12" cy="13" r="3"/>
                    </svg>
                </div>
                <div>
                    <div class="font-black text-2xl tracking-tight text-white">
                        Yero<span class="text-pink-500">.</span>
                    </div>
                    <div class="text-[10px] uppercase tracking-[.2em] text-slate-500">
                        Printing &amp; Studio
                    </div>
                </div>
            </div>

            <!-- Glass card -->
            <div class="rounded-3xl border border-white/10 bg-white/[.03] backdrop-blur-xl p-8 sm:p-10 shadow-2xl">
                <div class="mb-8">
                    <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        Welcome back
                    </h1>
                    <p class="mt-2 text-slate-400">
                        Sign in to your <span class="text-white font-semibold">Yero Printing</span> dashboard.
                    </p>
                </div>

                <!-- Inline error alert -->
                <?php if(!empty($errors)) { ?>
                    <div id="loginError" class="mb-6 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><?php echo $errors; ?></span>
                    </div>
                <?php } ?>

                <?php echo validation_errors('<div class="mb-6 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>', '</span></div>'); ?>

                <form action="<?php echo base_url('auth/login'); ?>" method="post" class="space-y-5">

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email address</label>
                        <div class="relative">
                            <span class="field-icon pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email"
                                   autocomplete="email" required
                                   placeholder="name@example.com"
                                   class="w-full py-4 pl-12 pr-4 rounded-xl
                                          bg-white/[.05] border border-white/10 text-white
                                          placeholder-slate-500 outline-none
                                          focus:border-pink-500 focus:ring-2 focus:ring-pink-500/30 transition">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-slate-300">Password</label>
                        </div>
                        <div class="relative">
                            <span class="field-icon pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password"
                                   autocomplete="current-password" required
                                   placeholder="Enter your password"
                                   class="w-full py-4 pl-12 pr-12 rounded-xl
                                          bg-white/[.05] border border-white/10 text-white
                                          placeholder-slate-500 outline-none
                                          focus:border-pink-500 focus:ring-2 focus:ring-pink-500/30 transition">
                            <button type="button" id="togglePassword"
                                    class="field-icon absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300"
                                    aria-label="Show password">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember + Submit -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 text-sm text-slate-400 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="sr-only peer">
                            <span class="w-5 h-5 rounded-md border border-white/15 bg-white/[.04] flex items-center justify-center
                                         peer-checked:bg-gradient-to-br peer-checked:from-orange-500 peer-checked:to-pink-500
                                         peer-checked:border-transparent transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            Remember me
                        </label>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full font-bold text-white
                                       bg-gradient-to-r from-orange-500 via-pink-500 to-purple-600
                                       shadow-xl shadow-pink-900/40
                                       hover:-translate-y-0.5 hover:shadow-pink-800/50
                                       active:translate-y-0
                                       transition">
                            Sign In
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Back to website -->
            <p class="mt-7 text-center text-slate-500">
                <a href="<?php echo base_url(); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-pink-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to website
                </a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            var input = document.getElementById('password');
            var eye = document.getElementById('eyeIcon');
            var eyeOff = document.getElementById('eyeOffIcon');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            eye.classList.toggle('hidden', show);
            eyeOff.classList.toggle('hidden', !show);
        });
    </script>
</body>
</html>