<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polling Units</title>
    <link rel="shortcut icon" href="../assets/vote_icon.png" type="image/png">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../fa_icons/css/all.css">
    <script src="../js/app.js"></script>
    <script src="../js/store/AuthServices.js"></script>
</head>
<body>
    <div class="min-h-dvh bg-slate-100">
        <section>
            <!-- Side Nav -->
            <aside class="-left-56 md:left-0 w-56 bg-secondary text-white fixed h-dvh shadow-sm">
                <?php include_once '../components/sidebar.html'; ?>
            </aside>

            
            <section class="md:ml-56">
                <!-- Header section -->
                <header class="min-h-10 px-4 py-3 bg-white shadow-sm sticky top-0">
                    <?php include_once '../components/header.html'; ?>
                </header>

                <!-- Main Content -->
                <main class="min-h-[1000px] px-4 py-3">
                    <!-- Polling Unit Design -->
                    <div class="flex items-start gap-2">
                        <!-- Top section (Search and Action Buttons) -->
                        <aside class="w-full max-w-2xl px-4 py-2">
                            <header class="flex items-start justify-between py-2 px-4 bg-white shadow-md rounded-md mb-7">
                                <div>
                                    <a href="pollunit.php" class="py-1 px-3 bg-primary text-sm font-semibold text-white rounded-lg inline-block">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </header>

                            <!-- Polling Units Table Section -->
                            <section class="px-4 py-2 bg-white rounded-xl shadow-md">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1 class="font-bold underline">
                                        Add Polling Unit
                                    </h1>
                                </div>

                                <form id="form_add_polling">
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="text" name="pollunit_id" required placeholder="Polling Unit Code" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-list-ol"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="text" name="address" required placeholder="Polling Unit Address" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-map"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <select id="province_id" name="province_id" required class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0">
                                                <option value="">Select Province</option>
                                            </select>
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-map-pin"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn-primary w-full justify-center gap-1 rounded-md h-9 text-white">
                                            <i class="fa fa-plus"></i> Add Polling Unit
                                        </button>
                                    </div>
                                </form>
                            </section>
                        </aside>

                        <!-- Officers (Right Pane) -->
                        <aside class="w-1/4 flex-shrink-0 px-4 py-2">
                            <!-- List of Officers -->
                            <section class="px-4 py-2 bg-white rounded-lg shadow-sm">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1 class="underline font-bold">
                                        Provinces
                                    </h1>

                                    <div>
                                        <a href="add_province.php" class="py-1 px-3 bg-primary text-xs font-semibold text-white rounded-lg inline-block">
                                            <i class="fa fa-plus"></i> Add
                                        </a>
                                    </div>
                                </div>
                                <ul id="provinces">
                                    <!-- Content Here is Generated by the fetchProvince() function in JavaScript -->
                                </ul>
                            </section>
                        </aside>
                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_polling_units').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-poll"></i> Add Polling Units';

        document.getElementById('form_add_polling').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(event.target);
            axios.post(`../../api/pollunit/add_unit.php`, formData)
            .then((res) => {
                if (res.data.success) {
                    alert(res.data.message);
                    event.target.reset();
                    location.href = 'pollunit.php';
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        })

        function loadPuOptions(provinces){
            let provincesHtml = '<option value="" selected>Select Province</option>';
            provinces.forEach((province) => {
                provincesHtml += `<option value="${province.id}">
                                ${province.province}
                            </option>`;
            });
            document.getElementById('province_id').innerHTML = provincesHtml;
        }

        function fetchProvince(){
            axios.get(`../../api/pollunit/fetch_province.php`)
            .then((res) => {
                if (res.data.success) {
                    let provincesHtml = '';
                    let provinces = res.data.provinces;
                    provinces.forEach((province) => {
                        provincesHtml += `<li class="flex items-center justify-between">
                                            <span>${province.province}</span>
                                            <button onclick="deleteProvince(${province.id})" class="p-1"><i class="fa fa-trash-alt text-red-500"></i></button>
                                        </li>`;
                    });
                    document.getElementById('provinces').innerHTML = provincesHtml;
                    loadPuOptions(provinces) // Load provinces on select options
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        }
        fetchProvince();

        function deleteProvince(id){
            axios.delete(`../../api/pollunit/delete_province.php?id=${id}`)
            .then((res) => {
                if (res.data.success) {
                    fetchProvince();
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        }
    </script>
</body>
</html>