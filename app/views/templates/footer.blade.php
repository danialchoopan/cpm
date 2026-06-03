    </main>
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} {{ get_setting()['site_name'] }}. تمامی حقوق محفوظ است.</p>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="login-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-8 w-full max-w-md">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">ورود به حساب</h3>
                <button onclick="document.getElementById('login-modal').classList.add('hidden')" class="text-gray-500 hover:text-red-500">&times;</button>
            </div>
            <div id="login-error" class="hidden bg-red-100 text-red-700 p-3 rounded mb-4"></div>
            <div class="space-y-4">
                <div>
                    <label class="block mb-1">ایمیل</label>
                    <input type="email" id="login-email" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block mb-1">رمز عبور</label>
                    <input type="password" id="login-password" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <button onclick="submitLogin()" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">ورود</button>
            </div>
            <div class="mt-4 text-center text-sm">
                <a href="{{ route('register/user') }}" class="text-blue-500 hover:underline">ثبت‌نام نکرده‌اید؟</a>
            </div>
        </div>
    </div>

    <script src="{{ assets('js/theme-toggle.js') }}"></script>
    <script>
        function submitLogin() {
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            const errorBox = document.getElementById('login-error');

            // در اینجا می‌توان از AJAX برای لاگین استفاده کرد (مشابه قبل)
            // به دلیل عدم وجود API در درخواست کاربر، فرض بر فرم بومی است یا AJAX به کنترلر
            fetch('{{ route("admin") }}', { // فرض بر مسیر لاگین ادمین یا ایجاد مسیر جدید
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${email}&password=${password}`
            }).then(res => {
                if (res.ok) location.reload();
                else {
                    errorBox.innerText = 'اطلاعات وارد شده صحیح نیست';
                    errorBox.classList.remove('hidden');
                }
            });
        }
    </script>
</body>
</html>
