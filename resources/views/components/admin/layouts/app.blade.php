<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Admin Panel' }}</title>
        <link rel="stylesheet" href="{{ asset('mads-template/assets/css/boxicons.min.css') }}">
        <style>
            :root { color-scheme: light; --bg:#f3f4f6; --panel:#fff; --text:#111827; --muted:#6b7280; --line:#e5e7eb; --line-strong:#d1d5db; --shadow:0 18px 45px rgba(17,24,39,.08); --brand:#111827; --brand-soft:#f59e0b; --success:#166534; --danger:#b91c1c; }
            * { box-sizing:border-box; }
            body { margin:0; font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif; background:linear-gradient(180deg,#f9fafb 0%,#eef2f7 100%); color:var(--text); }
            a { color:inherit; text-decoration:none; }
            button,input,textarea,select { font:inherit; }
            .admin-shell { min-height:100vh; display:grid; grid-template-columns:280px 1fr; }
            .sidebar { background:#0f172a; color:#fff; padding:28px 22px; }
            .brand { display:block; margin-bottom:26px; }
            .brand small { display:block; margin-top:8px; color:rgba(255,255,255,.65); letter-spacing:.08em; text-transform:uppercase; }
            .nav-section { margin-top:24px; }
            .nav-link,.nav-summary { display:flex; align-items:center; justify-content:space-between; width:100%; padding:12px 14px; border-radius:12px; color:rgba(255,255,255,.88); margin-bottom:8px; background:transparent; border:0; font:inherit; cursor:pointer; }
            .nav-link.active,.nav-link:hover,.nav-summary:hover { background:rgba(255,255,255,.08); color:#fff; }
            .nav-dropdown { margin-bottom:12px; }
            .nav-dropdown[open] .nav-summary { background:rgba(255,255,255,.08); color:#fff; }
            .nav-dropdown summary::-webkit-details-marker { display:none; }
            .nav-sublinks { padding-top:8px; padding-left:12px; }
            .nav-sublink { display:block; padding:10px 12px; border-radius:10px; color:rgba(255,255,255,.72); margin-bottom:6px; }
            .nav-sublink.active,.nav-sublink:hover { background:rgba(245,158,11,.16); color:#fff; }
            .sidebar-footer { margin-top:30px; padding-top:20px; border-top:1px solid rgba(255,255,255,.12); }
            .logout-btn { width:100%; padding:12px 14px; border-radius:12px; border:0; background:#f59e0b; color:#111827; font-weight:700; cursor:pointer; }
            .main { padding:28px; min-width:0; }
            .topbar { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:24px; }
            .page-title { margin:0; font-size:2rem; }
            .page-subtitle { margin:6px 0 0; color:var(--muted); }
            .user-badge { background:var(--panel); border:1px solid var(--line); border-radius:14px; padding:12px 16px; box-shadow:var(--shadow); color:var(--muted); }
            .panel { background:var(--panel); border:1px solid var(--line); border-radius:18px; box-shadow:var(--shadow); }
            .panel-body { padding:24px; }
            .stats-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px; }
            .stat-card { padding:22px; border-radius:18px; background:linear-gradient(135deg,#fff,#f9fafb); border:1px solid var(--line); }
            .stat-label { display:block; color:var(--muted); margin-bottom:10px; }
            .stat-value { font-size:1.65rem; font-weight:800; }
            .content-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
            .content-card { padding:22px; border-radius:18px; border:1px solid var(--line); background:#fff; }
            .content-card h3,.content-card p { margin-top:0; }
            .content-card p { color:var(--muted); line-height:1.7; }
            .content-card a { display:inline-block; margin-top:12px; font-weight:700; color:#b45309; }
            .login-shell { min-height:100vh; display:grid; place-items:center; padding:24px; background:linear-gradient(145deg,#0f172a 0%,#1f2937 50%,#111827 100%); }
            .login-card { width:min(100%,440px); background:rgba(255,255,255,.96); border-radius:22px; padding:30px; box-shadow:0 28px 80px rgba(0,0,0,.22); }
            .login-card h1 { margin-top:0; margin-bottom:10px; }
            .login-card p { color:var(--muted); line-height:1.7; }
            .field { margin-top:18px; }
            .field label { display:block; margin-bottom:8px; font-weight:700; }
            .field input,.field textarea,.field select { width:100%; padding:12px 14px; border-radius:12px; border:1px solid var(--line-strong); font:inherit; background:#fff; }
            .field textarea { resize:vertical; min-height:120px; }
            .field small { display:block; color:#b91c1c; margin-top:6px; }
            .checkbox-row { display:flex; align-items:center; gap:10px; margin-top:18px; color:var(--muted); }
            .primary-btn,.secondary-btn,.ghost-btn,.danger-btn { border:0; border-radius:12px; font-weight:700; cursor:pointer; padding:12px 16px; display:inline-flex; align-items:center; justify-content:center; gap:8px; }
            .primary-btn { background:var(--brand); color:#fff; }
            .secondary-btn { background:#e5e7eb; color:var(--text); }
            .ghost-btn { background:#fff; color:var(--text); border:1px solid var(--line); }
            .danger-btn { background:var(--danger); color:#fff; }
            .notice { margin-top:18px; padding:14px 16px; border-radius:12px; background:#fef3c7; color:#92400e; }
            .manager-toolbar { display:flex; justify-content:space-between; align-items:center; gap:14px; margin-bottom:18px; flex-wrap:wrap; }
            .manager-search { min-width:min(100%,320px); display:flex; align-items:center; gap:10px; padding:12px 14px; border:1px solid var(--line); border-radius:14px; background:#fff; }
            .manager-search input { border:0; outline:0; width:100%; padding:0; }
            .table-wrap { width:100%; overflow:auto; border:1px solid var(--line); border-radius:18px; }
            .manager-table { width:100%; border-collapse:collapse; min-width:980px; }
            .manager-table th,.manager-table td { padding:16px; border-bottom:1px solid var(--line); text-align:left; vertical-align:top; }
            .manager-table th { background:#f8fafc; color:#475569; font-size:.86rem; text-transform:uppercase; letter-spacing:.05em; position:sticky; top:0; z-index:1; }
            .sort-btn { background:none; border:0; color:inherit; font:inherit; text-transform:inherit; letter-spacing:inherit; display:inline-flex; align-items:center; gap:8px; cursor:pointer; padding:0; }
            .table-muted { color:var(--muted); line-height:1.6; }
            .status-badge { display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px; font-size:.82rem; font-weight:700; }
            .status-badge.active { background:#dcfce7; color:#166534; }
            .status-badge.hidden { background:#fee2e2; color:#991b1b; }
            .thumb { width:84px; height:64px; object-fit:cover; border-radius:14px; background:#e5e7eb; border:1px solid var(--line); }
            .icon-chip-preview { width:44px; height:44px; border-radius:14px; display:inline-flex; align-items:center; justify-content:center; background:#111827; color:#fff; font-size:22px; }
            .actions { display:flex; gap:10px; flex-wrap:wrap; }
            .modal-backdrop { position:fixed; inset:0; background:rgba(15,23,42,.62); display:none; align-items:center; justify-content:center; padding:24px; z-index:2000; }
            .modal-backdrop.open { display:flex; }
            .modal-card { width:min(960px, 100%); max-height:calc(100vh - 48px); overflow:auto; background:#fff; border-radius:22px; box-shadow:0 40px 90px rgba(15,23,42,.32); }
            .modal-header { padding:22px 24px; border-bottom:1px solid var(--line); display:flex; justify-content:space-between; align-items:flex-start; gap:14px; }
            .modal-header h2 { margin:0; }
            .modal-body { padding:24px; }
            .modal-close { background:#f3f4f6; border:0; width:42px; height:42px; border-radius:12px; cursor:pointer; font-size:20px; }
            .form-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:18px; }
            .form-grid .field.full { grid-column:1 / -1; }
            .icon-picker { display:grid; grid-template-columns:repeat(auto-fill, minmax(64px, 1fr)); gap:10px; margin-top:12px; }
            .icon-option { border:1px solid var(--line); background:#fff; border-radius:14px; padding:12px 8px; display:flex; flex-direction:column; align-items:center; gap:8px; cursor:pointer; transition:.2s ease; }
            .icon-option i { font-size:24px; }
            .icon-option span { font-size:.74rem; text-align:center; color:var(--muted); line-height:1.35; }
            .icon-option.active { border-color:#111827; background:#f8fafc; box-shadow:inset 0 0 0 1px #111827; }
            .file-meta { margin-top:10px; color:var(--muted); font-size:.92rem; }
            .empty-state { padding:24px; text-align:center; color:var(--muted); }
            [hidden] { display:none !important; }
            @media (max-width: 991px) {
                .admin-shell { grid-template-columns:1fr; }
                .stats-grid,.content-grid,.form-grid { grid-template-columns:1fr; }
                .manager-toolbar { align-items:stretch; }
                .manager-search { width:100%; min-width:0; }
                .topbar { align-items:flex-start; flex-direction:column; }
            }
        </style>
    </head>
    <body>
        {{ $slot }}
        <script>
            document.querySelectorAll('[data-modal-target]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var modal = document.getElementById(button.dataset.modalTarget);
                    if (modal) { modal.classList.add('open'); }
                });
            });
            document.querySelectorAll('[data-modal-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    button.closest('.modal-backdrop')?.classList.remove('open');
                });
            });
            document.querySelectorAll('.modal-backdrop').forEach(function (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) { modal.classList.remove('open'); }
                });
            });
            document.querySelectorAll('[data-open-modal]').forEach(function (element) {
                var modal = document.getElementById(element.dataset.openModal);
                if (modal) { modal.classList.add('open'); }
            });
            document.querySelectorAll('[data-search-input]').forEach(function (input) {
                input.addEventListener('input', function () {
                    var target = document.querySelector(input.dataset.searchInput);
                    if (! target) return;
                    var query = input.value.trim().toLowerCase();
                    target.querySelectorAll('[data-search-row]').forEach(function (row) {
                        var haystack = row.dataset.searchRow.toLowerCase();
                        row.hidden = query.length > 0 && ! haystack.includes(query);
                    });
                });
            });
            document.querySelectorAll('[data-sort-table]').forEach(function (table) {
                var tbody = table.querySelector('tbody');
                if (! tbody) return;
                table.querySelectorAll('[data-sort-key]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        var key = button.dataset.sortKey;
                        var type = button.dataset.sortType || 'text';
                        var direction = button.dataset.sortDirection === 'asc' ? 'desc' : 'asc';
                        button.dataset.sortDirection = direction;
                        var rows = Array.from(tbody.querySelectorAll('tr'));
                        rows.sort(function (a, b) {
                            var aValue = a.dataset[key] || '';
                            var bValue = b.dataset[key] || '';
                            if (type === 'number') {
                                return direction === 'asc' ? Number(aValue) - Number(bValue) : Number(bValue) - Number(aValue);
                            }
                            return direction === 'asc'
                                ? aValue.localeCompare(bValue)
                                : bValue.localeCompare(aValue);
                        });
                        rows.forEach(function (row) { tbody.appendChild(row); });
                    });
                });
            });
            document.querySelectorAll('[data-icon-picker]').forEach(function (picker) {
                var input = picker.querySelector('input[type="hidden"]');
                if (! input) return;
                picker.querySelectorAll('.icon-option').forEach(function (option) {
                    option.addEventListener('click', function () {
                        picker.querySelectorAll('.icon-option').forEach(function (item) { item.classList.remove('active'); });
                        option.classList.add('active');
                        input.value = option.dataset.iconValue;
                    });
                });
            });
            document.querySelectorAll('[data-file-input]').forEach(function (input) {
                input.addEventListener('change', function () {
                    var target = document.querySelector(input.dataset.fileInput);
                    if (! target) return;
                    target.textContent = input.files && input.files[0] ? input.files[0].name : target.dataset.emptyLabel;
                });
            });
        </script>
    </body>
</html>
