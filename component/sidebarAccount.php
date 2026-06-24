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

        <a href="/mijn-reviews" class="nav-item  <?php echo str_starts_with($currentPath, '/mijn-reviews') || $currentPath === '/mijn-reviews/{id}' ? 'active' : ''; ?> ">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.01819 0.8631C7.04741 0.804074 7.09254 0.754388 7.14849 0.71965C7.20445 0.684912 7.269 0.666504 7.33486 0.666504C7.40072 0.666504 7.46527 0.684912 7.52122 0.71965C7.57718 0.754388 7.62231 0.804074 7.65153 0.8631L9.19153 3.98243C9.29298 4.18774 9.44273 4.36537 9.62794 4.50007C9.81315 4.63477 10.0283 4.72251 10.2549 4.75577L13.6989 5.25977C13.7641 5.26922 13.8254 5.29675 13.8759 5.33923C13.9263 5.38172 13.9638 5.43747 13.9842 5.50017C14.0046 5.56288 14.007 5.63004 13.9912 5.69406C13.9755 5.75808 13.9421 5.8164 13.8949 5.86243L11.4042 8.28777C11.2399 8.44783 11.117 8.64542 11.0461 8.86352C10.9751 9.08162 10.9582 9.31369 10.9969 9.53977L11.5849 12.9664C11.5964 13.0317 11.5893 13.0988 11.5645 13.1602C11.5397 13.2216 11.4981 13.2748 11.4446 13.3138C11.391 13.3527 11.3275 13.3758 11.2614 13.3804C11.1954 13.385 11.1293 13.3709 11.0709 13.3398L7.99219 11.7211C7.78934 11.6146 7.56365 11.5589 7.33453 11.5589C7.10541 11.5589 6.87971 11.6146 6.67686 11.7211L3.59886 13.3398C3.54041 13.3707 3.47446 13.3846 3.40849 13.3799C3.34253 13.3752 3.2792 13.3521 3.22572 13.3132C3.17224 13.2743 3.13075 13.2212 3.10596 13.1599C3.08118 13.0986 3.0741 13.0316 3.08553 12.9664L3.67286 9.54043C3.71166 9.31425 3.69485 9.08203 3.62388 8.8638C3.55292 8.64556 3.42993 8.44787 3.26553 8.28777L0.774859 5.8631C0.727255 5.81712 0.693521 5.7587 0.6775 5.69448C0.66148 5.63027 0.663817 5.56284 0.684245 5.49989C0.704672 5.43694 0.74237 5.38099 0.793043 5.33842C0.843716 5.29585 0.905328 5.26837 0.970859 5.2591L4.41419 4.75577C4.64103 4.72277 4.85645 4.63514 5.04191 4.50042C5.22738 4.36571 5.37733 4.18795 5.47886 3.98243L7.01819 0.8631Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Mijn reviews
        </a>

        <a href="/logout" class="nav-item logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Uitloggen
        </a>
    </nav>
</aside>