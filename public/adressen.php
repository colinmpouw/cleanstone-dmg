<?php
$user = $_SESSION['user'] ?? null;
if (!$user) {
    header('Location: /login');
    exit;
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>adressen — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
    <link rel="stylesheet" href="/public/css/adressen.css">
</head>

<div class="modal-overlay" id="addressModal">

    <div class="address-modal">

        <div class="modal-header">
            <h2>Nieuw adres toevoegen</h2>
        </div>

        <form>

            <div class="form-row">
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" placeholder="Thuis, Werk...">
                </div>

                <div class="form-group">
                    <label>Naam</label>
                    <input type="text" placeholder="Voor- en achternaam">
                </div>
            </div>

            <div class="form-group">
                <label>Straat + huisnummer</label>
                <input type="text" placeholder="Hoofdstraat 12">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Postcode</label>
                    <input type="text" placeholder="1234 AB">
                </div>

                <div class="form-group">
                    <label>Stad</label>
                    <input type="text" placeholder="Amsterdam">
                </div>
            </div>

            <label class="checkbox">
                <input type="checkbox">
                Instellen als standaard bezorgadres
            </label>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeModal()">
                    Annuleren
                </button>

                <button class="save-btn">
                    Toevoegen
                </button>
            </div>

        </form>

    </div>

</div>
<body>

<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <main class="addresses-main">

        <div class="addresses-header">
            <h1>Mijn adressen</h1>

            <button class="new-address-btn" id="openModal">
                + Nieuw adres
            </button>
        </div>

        <div class="addresses-container">

            <div class="address-card default">

                <div class="address-left">

                    <div class="address-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 14V8.66667C10 8.48986 9.92976 8.32029 9.80474 8.19526C9.67971 8.07024 9.51014 8 9.33333 8H6.66667C6.48986 8 6.32029 8.07024 6.19526 8.19526C6.07024 8.32029 6 8.48986 6 8.66667V14" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.66673C1.99995 6.47277 2.04222 6.28114 2.12386 6.1052C2.20549 5.92927 2.32453 5.77326 2.47267 5.64806L7.13933 1.64873C7.37999 1.44533 7.6849 1.33374 8 1.33374C8.3151 1.33374 8.62001 1.44533 8.86067 1.64873L13.5273 5.64806C13.6755 5.77326 13.7945 5.92927 13.8761 6.1052C13.9578 6.28114 14 6.47277 14 6.66673V12.6667C14 13.0203 13.8595 13.3595 13.6095 13.6095C13.3594 13.8596 13.0203 14.0001 12.6667 14.0001H3.33333C2.97971 14.0001 2.64057 13.8596 2.39052 13.6095C2.14048 13.3595 2 13.0203 2 12.6667V6.66673Z" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div>
                        <div class="address-title">
                            <h3>Thuis</h3>
                            <span class="badge">Standaard</span>
                        </div>

                        <div class="address-info">
                            <p>Jan Jansen</p>
                            <p>Hoofdstraat 12</p>
                            <p>1234 AB Amsterdam</p>
                        </div>
                    </div>

                </div>

                <div class="address-actions">
                    <button class="icon-btn">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#editClip)">
                                <path d="M18.3513 9.97373C18.6597 9.66539 18.833 9.24717 18.8331 8.81106C18.8331 8.37495 18.6599 7.95668 18.3516 7.64827C18.0433 7.33985 17.625 7.16656 17.1889 7.1665C16.7528 7.16645 16.3345 7.33964 16.0261 7.64798L8.24097 15.4349C8.10553 15.5699 8.00537 15.7362 7.9493 15.9191L7.17872 18.4577C7.16364 18.5082 7.1625 18.5618 7.17542 18.6128C7.18834 18.6638 7.21484 18.7104 7.2521 18.7476C7.28936 18.7848 7.33599 18.8113 7.38706 18.8241C7.43812 18.8369 7.49171 18.8357 7.54213 18.8206L10.0814 18.0506C10.2641 17.995 10.4303 17.8954 10.5655 17.7606L18.3513 9.97373Z"
                                      stroke="#7E6A52"
                                      stroke-width="1.16667"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="editClip">
                                    <rect width="14" height="14" fill="white" transform="translate(6 6)"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.75 9.5H18.25" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.0832 9.5V17.6667C17.0832 18.25 16.4998 18.8333 15.9165 18.8333H10.0832C9.49984 18.8333 8.9165 18.25 8.9165 17.6667V9.5" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6665 9.50008V8.33341C10.6665 7.75008 11.2498 7.16675 11.8332 7.16675H14.1665C14.7498 7.16675 15.3332 7.75008 15.3332 8.33341V9.50008" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.8335 12.4167V15.9167" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.1665 12.4167V15.9167" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

            </div>

            <div class="address-card">

                <div class="address-left">

                    <div class="address-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 14V8.66667C10 8.48986 9.92976 8.32029 9.80474 8.19526C9.67971 8.07024 9.51014 8 9.33333 8H6.66667C6.48986 8 6.32029 8.07024 6.19526 8.19526C6.07024 8.32029 6 8.48986 6 8.66667V14" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.66673C1.99995 6.47277 2.04222 6.28114 2.12386 6.1052C2.20549 5.92927 2.32453 5.77326 2.47267 5.64806L7.13933 1.64873C7.37999 1.44533 7.6849 1.33374 8 1.33374C8.3151 1.33374 8.62001 1.44533 8.86067 1.64873L13.5273 5.64806C13.6755 5.77326 13.7945 5.92927 13.8761 6.1052C13.9578 6.28114 14 6.47277 14 6.66673V12.6667C14 13.0203 13.8595 13.3595 13.6095 13.6095C13.3594 13.8596 13.0203 14.0001 12.6667 14.0001H3.33333C2.97971 14.0001 2.64057 13.8596 2.39052 13.6095C2.14048 13.3595 2 13.0203 2 12.6667V6.66673Z" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div>
                        <div class="address-title">
                            <h3>Werk</h3>
                        </div>

                        <div class="address-info">
                            <p>Jan Jansen</p>
                            <p>Kantoorweg 55</p>
                            <p>1012 CD Amsterdam</p>

                            <span class="set-default">
                        Instellen als standaard
                    </span>
                        </div>
                    </div>

                </div>

                <div class="address-actions">
                    <button class="icon-btn">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#editClip)">
                                <path d="M18.3513 9.97373C18.6597 9.66539 18.833 9.24717 18.8331 8.81106C18.8331 8.37495 18.6599 7.95668 18.3516 7.64827C18.0433 7.33985 17.625 7.16656 17.1889 7.1665C16.7528 7.16645 16.3345 7.33964 16.0261 7.64798L8.24097 15.4349C8.10553 15.5699 8.00537 15.7362 7.9493 15.9191L7.17872 18.4577C7.16364 18.5082 7.1625 18.5618 7.17542 18.6128C7.18834 18.6638 7.21484 18.7104 7.2521 18.7476C7.28936 18.7848 7.33599 18.8113 7.38706 18.8241C7.43812 18.8369 7.49171 18.8357 7.54213 18.8206L10.0814 18.0506C10.2641 17.995 10.4303 17.8954 10.5655 17.7606L18.3513 9.97373Z"
                                      stroke="#7E6A52"
                                      stroke-width="1.16667"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="editClip">
                                    <rect width="14" height="14" fill="white" transform="translate(6 6)"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.75 9.5H18.25" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.0832 9.5V17.6667C17.0832 18.25 16.4998 18.8333 15.9165 18.8333H10.0832C9.49984 18.8333 8.9165 18.25 8.9165 17.6667V9.5" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6665 9.50008V8.33341C10.6665 7.75008 11.2498 7.16675 11.8332 7.16675H14.1665C14.7498 7.16675 15.3332 7.75008 15.3332 8.33341V9.50008" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.8335 12.4167V15.9167" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.1665 12.4167V15.9167" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

            </div>

        </div>

    </main>

</div>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>

<script src="/public/js/AiChat.js"></script>
<script src="/public/js/adressen.js"></script>

</body>
</html>