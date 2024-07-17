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
                    <div class="flex flex-col lg:flex-row items-start gap-2">
                        <!-- Top section (Search and Action Buttons) -->
                        <aside class="w-full px-4 py-2">
                            <header class="flex flex-col lg:flex-row gap-4 items-start justify-between py-2 px-4 bg-white shadow-md rounded-md mb-7">
                                <div>
                                    <form class="" id="search_officer_form">
                                        <div class="flex flex-col md:flex-row items-center bg-slate-100 rounded-md">
                                            <input type="search" id="search" class="h-8 bg-transparent focus:outline-none py-1 px-3" placeholder="Search Officer">
                                            <div class="flex items-center rounded-md w-full">
                                                <!-- <div class="flex flex-grow items-center max-w-full rounded-md border">
                                                    <select id="province_id" name="province_id" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0">
                                                        <option value="">Select Province</option>
                                                    </select>
                                                </div> -->
                                                <button class="py-1 px-2">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- <div class="mb-4">
                                            <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                                <select id="province_id" name="province_id" required class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0">
                                                    <option value="">Select Province</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    </form>
                                </div>

                                <div>
                                    <a href="add_officer.php" class="py-1 px-3 bg-primary text-sm font-semibold text-white rounded-lg inline-block">
                                        <i class="fa fa-plus"></i> Add Election Officer
                                    </a>
                                </div>
                            </header>

                            <!-- Polling Units Table Section -->
                            <section class="px-4 py-2 bg-white rounded-xl shadow-md">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1>
                                        Election Officers
                                    </h1>
                                </div>

                                <div class="max-w-full overflow-auto">
                                    <table class="w-full table-auto border-collapse border border-slate-400">
                                        <thead class="text-left">
                                            <tr>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-10">SN</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-3/5">Fullname</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-3/5">Email Address</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1">Contact Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody class="odd:bg-slate-100" id="officers-table">
                                            <!-- Pollinit Data is fetched and generate by the axios.get() method in the JS below  -->
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            
                        </aside>
                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_officers').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-user-tag"></i> Manage Officers';

        // Make a HTTP Get request to fetch all polling unit records
        axios.get(`../../api/voter/fetch_all_officers.php`)
        .then((res) => {
            let officersHTML = '';
            if (res.data.success) {
                res.data.officers.forEach((officer, index) => {
                    officersHTML += `<tr role="button" onclick="navigateOfficerProfile(${officer.id})">
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${index + 1}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${officer.firstname} ${officer.lastname}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${officer.email}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${officer.phone}</td>
                                    </tr>`;
                })
            }
            document.getElementById('officers-table').innerHTML = officersHTML;
        })

        function searchOfficers(){
            // Get the values from the inputs
            let search = document.getElementById('search').value;

            // make request to fetch polling units with the search values as parameters
            axios.get(`../../api/voter/fetch_all_officers.php?search=${search}`)
            .then((res) => {
                let officersHTML = '';
                if (res.data.success) {
                    let officers = res.data.officers;
                    if (officers.length > 0) { // If the records are more than zero(0)
                        res.data.officers.forEach((officer, index) => {
                            officersHTML += `<tr role="button" onclick="navigateOfficerProfile(${officer.id})">
                                            <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${index + 1}</td>
                                            <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${officer.firstname} ${officer.lastname}</td>
                                            <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${officer.email}</td>
                                            <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${officer.phone}</td>
                                        </tr>`;
                        })
                    } else {
                        // If there is no record
                        officersHTML += `<tr>
                                            <td class="border border-slate-300 px-3 py-1 whitespace-nowrap text-center"  colspan="6">No Record of officer found!</td>
                                        </tr>`;
                    }
                    
                }
                document.getElementById('officers-table').innerHTML = officersHTML;
            })
        }

        document.getElementById('search_officer_form').addEventListener('submit', function(event){
            event.preventDefault();
            searchOfficers();
        })

        function navigateOfficerProfile(officer_id){
            location.href = 'officer_profile.php?officer_id=' + officer_id;
        }
    </script>
</body>
</html>