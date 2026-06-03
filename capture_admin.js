const playwright = require('playwright');

(async () => {
  const browser = await playwright.chromium.launch();
  const context = await browser.newContext({
    viewport: { width: 1280, height: 800 },
    locale: 'fa-IR',
    dir: 'rtl'
  });
  const page = await context.newPage();

  // Login as admin
  await page.goto('http://localhost:8000/auth/login');
  await page.fill('input[name="email"]', 'admin@cpm.ir');
  await page.fill('input[name="password"]', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/admin/dashboard');

  await page.screenshot({ path: 'public/assets/img/screenshots/admin_dashboard.png', fullPage: true });

  await browser.close();
})();
