<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="../assets/vote_icon.png" type="image/png">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../fa_icons/css/all.css">
    <script src="../js/app.js"></script>
    <script src="../js/store/AuthServices.js"></script>
    <script>
        if (getUser().role == 'voter') {
            location.href = 'profile.php';
        }
    </script>
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
                <header class="min-h-10 px-4 py-3 bg-white shadow-sm sticky top-0 z-10">
                    <?php include_once '../components/header.html'; ?>
                </header>

                <!-- Main Content -->
                <main class="min-h-[1000px] px-4 py-3">
                    <!-- Dashboard Design -->
                    <div class="flex items-start gap-2">
                        <!-- Statistics Card and Voters Table -->
                        <aside class="w-full px-4 py-2">
                            <!-- Cards section -->
                            <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-7">
                                <!-- Card 1 -->
                                <a href="voters.php" class="bg-white min-h-10 rounded-lg shadow-lg px-3 py-2 relative">
                                    <span class="text-sm">No. of Voters</span>
                                    <h1 id="voter-count" class="text-5xl font-bold">
                                        0
                                    </h1>
                                    <button class="absolute right-4 bottom-2 text-2xl text-primary">
                                        <i class="fa fa-users"></i>
                                    </button>
                                </a>
                                <!-- Card 2 -->
                                <a href="officers.php"  class="bg-white min-h-10 rounded-lg shadow-lg px-3 py-2 relative">
                                    <span class="text-sm">No. of Election Officers</span>
                                    <h1 id="officer-count" class="text-5xl font-bold">
                                        0
                                    </h1>
                                    <button class="absolute right-4 bottom-2 text-2xl text-primary">
                                        <i class="fa fa-user-tag"></i>
                                    </button>
                                </a>
                                <!-- Card 3 -->
                                <a href="pollunit.php"  class="bg-white min-h-10 rounded-lg shadow-lg px-3 py-2 relative">
                                    <span class="text-sm">No. of Province</span>
                                    <h1 id="province-count" class="text-5xl font-bold">
                                        0
                                    </h1>
                                    <button class="absolute right-4 bottom-2 text-2xl text-primary">
                                        <i class="fa fa-home"></i>
                                    </button>
                                </a>
                            </section>

                            <!-- Voters Table Section -->
                            <section class="px-4 py-2 bg-white rounded-xl shadow-md">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1>
                                        Voter's Records
                                    </h1>

                                    <a href="voters.php" class="text-sm text-primary hover:underline">Vew All Voters</a>
                                </div>

                                <table class="w-full table-auto border-collapse border border-slate-400">
                                    <thead class="text-left">
                                        <tr>
                                            <th class="border border-slate-300 px-3 py-1 w-10">SN</th>
                                            <th class="border border-slate-300 px-3 py-1 w-3/5">Fullname</th>
                                            <th class="border border-slate-300 px-3 py-1">Voter ID</th>
                                            <th class="border border-slate-300 px-3 py-1" colspan="2">Polling Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="voter-records" class="odd:bg-slate-100">
                                        
                                    </tbody>
                                </table>
                            </section>
                        </aside>

                        <!-- Polling Units Count and Officers (Right Pane) -->
                        <aside class="w-2/6 flex-shrink-0 px-4 py-2">
                            <!-- Polling unit card -->
                            <div class="bg-white min-h-10 rounded-lg shadow-lg px-3 py-2 relative mb-7">
                                <h1 class="text-5xl font-bold">
                                    <span id="poll-unit-count">0</span>
                                    <span class="text-base">Polling Units</span> <br>
                                </h1>
                                <a href="pollunit.php" class="text-sm text-primary hover:underline">View & Manage Polling units</a>
                            </div>

                            <!-- List of Officers -->
                            <section class="px-4 py-2 bg-white rounded-lg shadow-sm">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1>
                                        Election Officers
                                    </h1>

                                    <a href="officers.php" class="text-sm text-primary hover:underline">Vew All Officers</a>
                                </div>
                                <ul id="officers-list">
                                </ul>
                            </section>
                        </aside>
                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_dashboard').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-tachometer-alt"></i> Dashboard';


        axios.get(`../../api/stats/dashboard_stats.php`)
        .then((res) => {
            let stats = res.data.stats;

            // Displaying the statistics on their various elements
            document.getElementById('voter-count').innerText = stats.no_voter;
            document.getElementById('officer-count').innerText = stats.no_officer;
            document.getElementById('province-count').innerText = stats.no_province;
            document.getElementById('poll-unit-count').innerText = stats.no_poll_unit;

            // Check the lenght of voter records
            let votersHTML = '';
            if (stats.voter_list.length > 0) {
                stats.voter_list.forEach((voter, i) => {
                    votersHTML += `<tr>
                                        <td class="border border-slate-300 px-3 py-1">${i + 1}</td>
                                        <td class="border border-slate-300 px-3 py-1">${voter.firstname} ${voter.lastname}</td>
                                        <td class="border border-slate-300 px-3 py-1">${voter.vote_id}</td>
                                        <td class="border border-slate-300 px-3 py-1">${(voter.polling_unit) ? voter.polling_unit.punit_code : ' - '}</td>
                                        <td class="border border-slate-300 px-3 py-1">
                                            <button class="px-2" onclick="navigateVoterProfile(${voter.user_id})">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                });
            } else {
                votersHTML += `<tr>
                                <td class="border border-slate-300 px-3 py-1" colspan="4"> No Voter record found. </td>
                            </tr>`;
            }

            document.getElementById('voter-records').innerHTML = votersHTML;

            // Check the lenght of officers records
            let officersHTML = '';
            if (stats.officer_list.length > 0) {
                stats.officer_list.forEach((officer, i) => {
                    officersHTML += `<li>
                                        ${officer.firstname} ${officer.lastname}
                                    </li>`;
                });
            } else {
                officersHTML += `<li>
                                    No Election officer Found
                                </li>`;
            }

            document.getElementById('officers-list').innerHTML = officersHTML;
        })

        function navigateVoterProfile(voter_id){
            location.href = 'voter_profile.php?voter_id=' + voter_id;
        }
    </script>
</body>
</html>