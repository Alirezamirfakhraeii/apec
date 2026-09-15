(() => {
    const csrf = () => document.querySelector('input[name="_token"]')?.value || '';
    const debounce = (fn, wait = 700) => { let timer; return (...args) => { clearTimeout(timer); timer = setTimeout(() => fn(...args), wait); }; };

    const clearErrors = (form) => form.querySelectorAll('[data-error-for]').forEach(el => el.textContent = '');
    const showErrors = (form, errors = {}) => Object.entries(errors).forEach(([field, messages]) => {
        const el = form.querySelector(`[data-error-for="${CSS.escape(field)}"]`);
        if (el) el.textContent = Array.isArray(messages) ? messages[0] : messages;
    });
    const setStatus = (el, text, cls = '') => {
        if (!el) return;
        el.textContent = text;
        el.classList.remove('is-saving','is-saved','is-error');
        if (cls) el.classList.add(cls);
    };

    async function sendForm(form) {
        const status = form.querySelector('[data-form-status]') || document.querySelector('[data-global-save-status]');
        clearErrors(form); setStatus(status, 'در حال ذخیره…', 'is-saving');
        const response = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json().catch(() => ({}));
        if (!response.ok) { showErrors(form, data.errors || {}); setStatus(status, data.message || 'خطا در ذخیره', 'is-error'); throw data; }
        setStatus(status, data.message || 'ذخیره شد', 'is-saved');
        return data;
    }

    document.querySelectorAll('[data-autosave-form]').forEach(form => {
        const save = debounce(() => sendForm(form).catch(() => {}), 800);
        form.addEventListener('input', e => { if (!e.target.matches('input[type=file]')) save(); });
        form.addEventListener('change', e => { if (!e.target.matches('input[type=file]')) sendForm(form).catch(() => {}); });
        form.querySelectorAll('[data-save-and-go]').forEach(btn => btn.addEventListener('click', async () => {
            try { await sendForm(form); window.location.href = btn.dataset.saveAndGo; } catch (_) {}
        }));
    });

    document.querySelectorAll('[data-intake-form]').forEach(form => form.addEventListener('submit', async e => {
        e.preventDefault();
        const status = form.querySelector('[data-form-status]'); clearErrors(form); setStatus(status, 'در حال ثبت…', 'is-saving');
        const response = await fetch(form.action, { method:'POST', body:new FormData(form), headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} });
        const data = await response.json().catch(() => ({}));
        if (!response.ok) { showErrors(form, data.errors || {}); setStatus(status, data.message || 'خطا', 'is-error'); return; }
        window.location.href = data.redirect || form.dataset.redirectFallback;
    }));

    document.querySelectorAll('[data-upload-form]').forEach(form => {
        const input = form.querySelector('[data-auto-upload]'); const status = form.querySelector('[data-upload-status]');
        input?.addEventListener('change', async () => {
            if (!input.files?.length) return;
            clearErrors(form); setStatus(status, 'در حال بارگذاری…', 'is-saving');
            const response = await fetch(form.action, { method:'POST', body:new FormData(form), headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) { showErrors(form, data.errors || {}); setStatus(status, data.message || 'خطای بارگذاری', 'is-error'); return; }
            setStatus(status, data.document?.name || data.message || 'بارگذاری شد', 'is-saved');
            if (data.url) { const preview = document.querySelector('[data-logo-preview]'); if (preview) preview.innerHTML = `<img src="${data.url}" alt="لوگوی شرکت">`; }
        });
    });

    document.querySelectorAll('[data-shareholder-form]').forEach(form => form.addEventListener('submit', async e => {
        e.preventDefault(); clearErrors(form);
        const response = await fetch(form.action, { method:'POST', body:new FormData(form), headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} });
        const data = await response.json().catch(() => ({}));
        if (!response.ok) { showErrors(form, data.errors || {}); return; }
        window.location.reload();
    }));

    document.querySelectorAll('[data-delete-url]').forEach(btn => btn.addEventListener('click', async () => {
        if (!confirm('این آیتم حذف شود؟')) return;
        const body = new FormData(); body.append('_token', csrf()); body.append('_method', 'DELETE');
        const response = await fetch(btn.dataset.deleteUrl, { method:'POST', body, headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} });
        if (response.ok) window.location.reload();
    }));

    document.querySelectorAll('[data-money]').forEach(input => {
        const format = () => { const raw = input.value.replace(/[^0-9۰-۹]/g, '').replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d)); input.value = raw ? Number(raw).toLocaleString('en-US') : ''; };
        input.addEventListener('blur', format); format();
    });

    const toggleChamber = () => {
        const selected = document.querySelector('[data-chamber-member]:checked')?.value;
        document.querySelectorAll('[data-chamber-card]').forEach(el => el.style.display = selected === '1' ? '' : 'none');
    };
    document.querySelectorAll('[data-chamber-member]').forEach(el => el.addEventListener('change', toggleChamber));
    toggleChamber();
})();
