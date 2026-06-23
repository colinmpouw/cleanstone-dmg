<?php
$currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/');
$currentPath = $currentPath === '' ? '/' : $currentPath;
$sidebarUser = $_SESSION['user'] ?? ($user ?? null);
?>

<aside class="sidebar">

    <div class="sidebar__profile">
        <div class="sidebar__avatar">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v2h20v-2c0-3.3-6.7-5-10-5z"/></svg>
        </div>
        <span class="sidebar__name"><?php echo htmlspecialchars($sidebarUser['username'] ?? 'Gebruiker', ENT_QUOTES, 'UTF-8'); ?></span>
        <span class="sidebar__email"><?php echo htmlspecialchars($sidebarUser['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
    </div>

    <nav class="sidebar__nav">
        <a href="/account" class="nav-item <?php echo in_array($currentPath, ['/account', '/account-overzicht'], true) ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Overzicht
        </a>
        <a href="/show-advies" class="nav-item <?php echo str_starts_with($currentPath, '/show-advies') || $currentPath === '/advies' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Adviesaanvraag
        </a>
        <a href="/bestellingen" class="nav-item  <?php echo str_starts_with($currentPath, '/bestellingen') || $currentPath === '/bestellingen/{id}' ? 'active' : ''; ?> ">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            Bestellingen
        </a>
        <a href="/adressen" class="nav-item  <?php echo str_starts_with($currentPath, '/adressen') || $currentPath === '/bestellingen/{id}' ? 'active' : ''; ?> ">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 14V8.66667C10 8.48986 9.92976 8.32029 9.80474 8.19526C9.67971 8.07024 9.51014 8 9.33333 8H6.66667C6.48986 8 6.32029 8.07024 6.19526 8.19526C6.07024 8.32029 6 8.48986 6 8.66667V14" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 6.66673C1.99995 6.47277 2.04222 6.28114 2.12386 6.1052C2.20549 5.92927 2.32453 5.77326 2.47267 5.64806L7.13933 1.64873C7.37999 1.44533 7.6849 1.33374 8 1.33374C8.3151 1.33374 8.62001 1.44533 8.86067 1.64873L13.5273 5.64806C13.6755 5.77326 13.7945 5.92927 13.8761 6.1052C13.9578 6.28114 14 6.47277 14 6.66673V12.6667C14 13.0203 13.8595 13.3595 13.6095 13.6095C13.3594 13.8596 13.0203 14.0001 12.6667 14.0001H3.33333C2.97971 14.0001 2.64057 13.8596 2.39052 13.6095C2.14048 13.3595 2 13.0203 2 12.6667V6.66673Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            adressen
        </a>
        <a href="/logout" class="nav-item logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Uitloggen
        </a>
    </nav>
</aside>