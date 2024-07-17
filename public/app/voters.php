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
                                    <form class="" id="search_voters_form">
                                        <div class="flex flex-col md:flex-row items-center bg-slate-100 rounded-md">
                                            <input type="search" id="search" class="h-8 bg-transparent focus:outline-none py-1 px-3" placeholder="Search Voters">
                                            <div class="flex items-center rounded-md w-full">
                                            <div class="flex flex-grow items-center max-w-full rounded-md border">
                                                    <select id="province_id" name="province_id" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0">
                                                        <option value="">Select Province</option>
                                                    </select>
                                                </div>
                                                <div class="flex flex-grow items-center max-w-full rounded-md border">
                                                    <select id="poll_unit_id" name="poll_unit_id" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0">
                                                        <option value="">Select Polling Unit</option>
                                                    </select>
                                                </div>
                                                <button class="py-1 px-2">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- <div>
                                    <a href="add_pollunit.php" class="py-1 px-3 bg-primary text-sm font-semibold text-white rounded-lg inline-block">
                                        <i class="fa fa-plus"></i> Add Polling Unit
                                    </a>
                                </div> -->
                            </header>

                            <!-- Polling Units Table Section -->
                            <section class="px-4 py-2 bg-white rounded-xl shadow-md">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1>
                                        List of Voters
                                    </h1>
                                </div>

                                <div class="max-w-full overflow-auto">
                                    <table class="w-full table-auto border-collapse border border-slate-400">
                                        <thead class="text-left">
                                            <tr>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-10">SN</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-3/5">Fullname</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-3/5">Email</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1 w-3/5">Phone</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1">Province</th>
                                                <th class="whitespace-nowrap border border-slate-300 px-3 py-1">Polling Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="odd:bg-slate-100" id="voters-table">
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
        document.getElementById('mnu_voters').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-users"></i> Manage Voters';

        // Make a HTTP Get request to fetch all polling unit records
        axios.get(`../../api/voter/fetch_all.php`)
        .then((res) => {
            let votersHTML = '';
            if (res.data.success) {
                res.data.voters.forEach((voter, index) => {
                    votersHTML += `<tr role="button" onclick="navigateVoterProfile(${voter.user_id})">
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${index + 1}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.firstname} ${voter.lastname}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.email}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.phone}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.province?.name}</td>
                                        <td class="border border-slate-300 px-3 py-1 whitespace-nowrap leading-4"><span>${voter.polling_unit?.punit_code}</span> <br> <small class="text-primary">(${voter.polling_unit?.punit_address})</small></td>
                                    </tr>`;
                })
            }
            document.getElementById('voters-table').innerHTML = votersHTML;
        })

        function fetchProvince(){
            axios.get(`../../api/pollunit/fetch_province.php`)
            .then((res) => {
                if (res.data.success) {
                    let provinces = res.data.provinces;
                    let provincesHtml = '<option value="" selected>Select Province</option>';
                    provinces.forEach((province) => {
                        provincesHtml += `<option value="${province.id}">
                                        ${province.province}
                                    </option>`;
                    });
                    document.getElementById('province_id').innerHTML = provincesHtml;
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

        function searchVoters(){
            // Get the values from the inputs
            let search = document.getElementById('search').value;
            let province_id = document.getElementById('province_id').value;

            // make request to fetch polling units with the search values as parameters
            axios.get(`../../api/voter/fetch_all.php?search=${search}&province_id=${province_id}`)
            .then((res) => {
                let votersHTML = '';
                if (res.data.success) {
                    let voters = res.data.voters;
                    if (voters.length > 0) { // If the records are more than zero(0)
                        res.data.voters.forEach((voter, index) => {
                            votersHTML += `<tr role="button" onclick="navigateVoterProfile(${voter.user_id})">
                                                <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${index + 1}</td>
                                                <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.firstname} ${voter.lastname}</td>
                                                <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.email}</td>
                                                <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.phone}</td>
                                                <td class="border border-slate-300 px-3 py-1 whitespace-nowrap">${voter.province?.name}</td>
                                                <td class="border border-slate-300 px-3 py-1 whitespace-nowrap leading-4"><span>${voter.polling_unit?.punit_code}</span> <br> <small class="text-primary">(${voter.polling_unit?.punit_address})</small></td>
                                            </tr>`;
                        })
                    } else {
                        // If there is no record
                        votersHTML += `<tr>
                                            <td class="border border-slate-300 px-3 py-1 whitespace-nowrap text-center"  colspan="6">No Record of Voter found!</td>
                                        </tr>`;
                    }
                    
                }
                document.getElementById('voters-table').innerHTML = votersHTML;
            })
        }

        // Listen to the change event of the polling unit select input
        document.getElementById('province_id').addEventListener('change', function(){
            searchVoters();
        })

        document.getElementById('search_voters_form').addEventListener('submit', function(event){
            event.preventDefault();
            searchVoters();
        })

        function navigateVoterProfile(voter_id){
            location.href = 'voter_profile.php?voter_id=' + voter_id;
        }
    </script>
</body>
</html>