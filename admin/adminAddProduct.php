<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Product bewerken</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">

    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminAddProduct.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<!-- MAIN -->
<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <!-- CONTENT -->
    <main class="content">
        <div class="edit-heading">
            <div class="edit-heading-left">
                <div>
                    <h1>Product toevoegen</h1>
                    <p>Nieuw product aanmaken</p>
                </div>
            </div>
            <div class="edit-heading-actions">
                <a href="/admin/producten" class="btn-cancel">Annuleren</a>
                <button class="btn-save" id="saveBtn">Opslaan</button>
            </div>
        </div>

        <form id="productForm" class="edit-grid">
            <!-- LEFT COLUMN -->
            <div class="edit-col-left">
                <div class="panel">
                    <div class="panel-header">
                        <h2>Productfoto's</h2>
                        <span id="photoCount" class="panel-header-meta">0 foto's</span>
                    </div>

                    <div class="photo-main" id="photoMain">
                        <span class="photo-main-badge">
                           <svg width="10" height="10" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_647_727)">
<path d="M4.32157 0.860631C4.33801 0.827429 4.36339 0.799481 4.39487 0.77994C4.42634 0.7604 4.46265 0.750046 4.4997 0.750046C4.53674 0.750046 4.57305 0.7604 4.60453 0.77994C4.636 0.799481 4.66139 0.827429 4.67782 0.860631L5.54407 2.61526C5.60114 2.73074 5.68538 2.83066 5.78956 2.90643C5.89374 2.98219 6.01475 3.03155 6.1422 3.05026L8.07945 3.33376C8.11616 3.33907 8.15064 3.35456 8.17901 3.37846C8.20737 3.40235 8.22848 3.43371 8.23996 3.46898C8.25143 3.50426 8.2528 3.54203 8.24392 3.57804C8.23504 3.61406 8.21626 3.64686 8.1897 3.67276L6.7887 5.03701C6.6963 5.12704 6.62717 5.23819 6.58726 5.36087C6.54735 5.48355 6.53785 5.61409 6.55957 5.74126L6.89032 7.66876C6.8968 7.70545 6.89284 7.74322 6.87889 7.77776C6.86493 7.81231 6.84155 7.84223 6.8114 7.86413C6.78126 7.88602 6.74557 7.89901 6.7084 7.90159C6.67123 7.90418 6.63408 7.89627 6.6012 7.87876L4.86945 6.96826C4.75534 6.90834 4.62839 6.87704 4.49951 6.87704C4.37063 6.87704 4.24368 6.90834 4.12957 6.96826L2.3982 7.87876C2.36532 7.89616 2.32822 7.90399 2.29112 7.90135C2.25401 7.89871 2.21839 7.88572 2.18831 7.86384C2.15823 7.84196 2.13489 7.81208 2.12094 7.77759C2.107 7.7431 2.10302 7.70539 2.10945 7.66876L2.43982 5.74163C2.46165 5.61441 2.45219 5.48378 2.41228 5.36102C2.37236 5.23827 2.30318 5.12706 2.2107 5.03701L0.809698 3.67313C0.782921 3.64727 0.763946 3.6144 0.754934 3.57828C0.745923 3.54216 0.747237 3.50424 0.758728 3.46883C0.770219 3.43342 0.791423 3.40195 0.819927 3.378C0.848431 3.35405 0.883087 3.33859 0.919948 3.33338L2.85682 3.05026C2.98442 3.03169 3.10559 2.9824 3.20992 2.90663C3.31424 2.83085 3.39859 2.73086 3.4557 2.61526L4.32157 0.860631Z"
      fill="white" stroke="white" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_647_727">
<rect width="9" height="9" fill="white"/>
</clipPath>
</defs>
</svg>

                            Hoofdfoto
                        </span>
                        <img id="photoMainImg" src="" alt="" hidden>
                        <div class="photo-main-empty" id="photoMainEmpty">

                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12 18C14.7614 18 17 15.7614 17 13C17 10.2386 14.7614 8 12 8C9.23858 8 7 10.2386 7 13C7 15.7614 9.23858 18 12 18ZM12 16.0071C10.3392 16.0071 8.9929 14.6608 8.9929 13C8.9929 11.3392 10.3392 9.9929 12 9.9929C13.6608 9.9929 15.0071 11.3392 15.0071 13C15.0071 14.6608 13.6608 16.0071 12 16.0071Z"
                                          fill="#0F0F0F"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.56155 2C8.18495 2 6.985 2.93689 6.65112 4.27239L6.21922 6H4C2.34315 6 1 7.34315 1 9V19C1 20.6569 2.34315 22 4 22H20C21.6569 22 23 20.6569 23 19V9C23 7.34315 21.6569 6 20 6H17.7808L17.3489 4.27239C17.015 2.93689 15.8151 2 14.4384 2H9.56155ZM8.59141 4.75746C8.7027 4.3123 9.10268 4 9.56155 4H14.4384C14.8973 4 15.2973 4.3123 15.4086 4.75746L15.8405 6.48507C16.0631 7.37541 16.863 8 17.7808 8H20C20.5523 8 21 8.44772 21 9V19C21 19.5523 20.5523 20 20 20H4C3.44772 20 3 19.5523 3 19V9C3 8.44772 3.44772 8 4 8H6.21922C7.13696 8 7.93692 7.37541 8.15951 6.48507L8.59141 4.75746Z"
                                          fill="#0F0F0F"></path>
                                </g>
                            </svg>

                        </div>
                    </div>

                    <div class="photo-thumbs" id="photoThumbs">
                        <!-- Existing photo thumbnails injected by JS -->
                        <label class="photo-thumb photo-thumb--add" id="photoAddTile">
                            <svg width="25" height="25" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.75 9H14.25" stroke="#DACFB6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 3.75V14.25" stroke="#DACFB6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <input type="file" id="photoInput" accept="image/*" multiple hidden>
                        </label>
                    </div>
                </div>

                <div class="tips-box">
                    <h3>Tips voor productfoto's</h3>
                    <p>De eerste foto wordt de hoofdfoto. Gebruik vierkante beelden van minimaal 800×800px voor de beste
                        weergave in de webshop.</p>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="edit-col-right">
                <div class="panel">
                    <h2>Basisinformatie</h2>

                    <div class="field">
                        <label for="productName">Productnaam</label>
                        <input type="text" id="productName" name="name" placeholder="Productnaam">
                    </div>

                    <div class="field">
                        <label for="productDescription">Beschrijving</label>
                        <textarea id="productDescription" name="description" rows="5"
                                  placeholder="Beschrijf het product..."></textarea>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label for="productBrand">Merk</label>
                            <select id="productBrand" name="brand_id">
                                <option value="">Selecteer merk</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="productCategory">Categorie</label>
                            <select id="productCategory" name="category_id">
                                <option value="">Selecteer categorie</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label for="tagSearchInput">Tags</label>
                        <div class="tag-select" id="tagSelect">
                            <div class="tag-select-chips" id="tagChips">
                                <!-- Selected tag chips injected by JS -->
                            </div>
                            <input type="text" id="tagSearchInput" placeholder="Tag toevoegen...">
                            <div class="tag-select-dropdown" id="tagDropdown" hidden>
                                <!-- Available tag options injected by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h2>Prijs</h2>

                    <div class="field-row">
                        <div class="field">
                            <label for="productPrice">Verkoopprijs (€)</label>
                            <input type="number" id="productPrice" name="price" step="0.01" min="0" placeholder="0.00">
                        </div>
                        <div class="field">
                            <label for="productComparePrice">
                                Vergelijkprijs (€) <span class="field-optional">optioneel</span>
                            </label>
                            <input type="number" id="productComparePrice" name="sale_price" step="0.01" min="0"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="discount-note" id="discountNote" hidden></div>
                </div>

                <div class="panel">
                    <h2>Voorraad &amp; status</h2>

                    <div class="field-row">
                        <div class="field">
                            <label for="productStock">Voorraad (stuks)</label>
                            <input type="number" id="productStock" name="stock" min="0" step="1" placeholder="0">
                        </div>
                        <div class="field">
                            <label for="productSku">SKU / Artikelnummer</label>
                            <input type="text" id="productSku" name="sku" placeholder="SKU">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script src="/admin/js/adminAddProduct.js"></script>
</body>
</html>