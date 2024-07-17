<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
                    <div class="bg-white rounded-md shadow-md overflow-hidden mb-5">
                        <section class="h-32 bg-slate-400">
                            <a href="voters.php" class="bg-secondary inline-block py-1 px-3 border border-white text-white mt-4 ml-4 text-xs rounded-lg shadow-md">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                            <button onclick="deleteUser()" class="bg-primary inline-block py-1 px-3 border border-white text-white mt-4 ml-4 text-xs rounded-lg shadow-md">
                                <i class="fas fa-trash-alt"></i>
                                Delete Officer <span class="hidden" id="user_id_span"></span>
                            </button>
                        </section>
                        <section class="h-32 w-32 rounded-full bg-primary mx-auto -mt-24 flex items-center overflow-hidden">
                            <img id="user_profile_image" src="" alt="" class="object-cover min-h-full min-w-full">
                        </section>
                        
                        <section class="text-center py-4 px-4">
                            <h1 id="usernames" class="font-bold text-3xl">
                                Destiny James
                            </h1>
                            <span id="user_email" class="text-secondary text-sm italic -mt-1"></span> 
                            <span id="user_profile_role" class="text-primary capitalize"></span>
                        </section>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-6">
                        <section class="bg-white rounded-md shadow-md overflow-hidden mb-5 px-4 py-2">
                            <h1 class="text-xl font-bold border-b border-slate-500 py-2 mb-3">
                                User Bio
                            </h1>
                            <aside class="space-y-3">
                                <div>
                                    <strong>Firstname: </strong> <span id="span_firstname"></span>
                                </div>
                                <div>
                                    <strong>Lastname: </strong> <span id="span_lastname"></span>
                                </div>
                                <div>
                                    <strong>Email: </strong> <span id="span_email"></span>
                                </div>
                                <div>
                                    <strong>Phone: </strong> <span id="span_phone"></span>
                                </div>
                                <div>
                                    <strong>Gender: </strong> <span id="span_gender"></span>
                                </div>
                                <div>
                                    <strong>Date of Birth: </strong> <span id="span_dob"></span>
                                </div>
                                <div>
                                    <strong>About (Bio): </strong> <span id="span_bio"></span>
                                </div>
                            </aside>
                        </section>
                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_voters').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-user"></i> Voter\'s Profile';

        // Get user id from the page url
        let url = new URL(location.href);
        let officer_id = url.searchParams.get('officer_id');

        if (officer_id == null || officer_id == undefined || officer_id == '') {
            location.href = 'voters.php';
        }

        // Function to Fetch Voters Information
        function fetchOfficerInformation(){
            axios.get(`../../api/voter/officer_profile_info.php?officer_id=${officer_id}`, {
                headers : {
                    'Authorization' : 'Bearer ' + getToken()
                }
            })
            .then((res) => {
                if (res.data.success) {
                    let officer = res.data.officer;
                    // Add User Data to Page Elements
                    document.getElementById('user_profile_image').setAttribute('src', "../" + officer.photo);
                    document.getElementById('usernames').innerText =  officer.firstname + " " + officer.lastname;
                    document.getElementById('user_profile_role').innerText = " - " + officer.role;
                    document.getElementById('user_email').innerText =  officer.email;
                    document.getElementById('span_firstname').innerText =  officer.firstname;
                    document.getElementById('span_lastname').innerText =  officer.lastname;
                    document.getElementById('span_email').innerText =  officer.email;
                    document.getElementById('span_phone').innerText =  officer.phone;
                    document.getElementById('span_gender').innerText =  officer.gender;
                    document.getElementById('span_dob').innerText =  moment(officer.dob).format('DD/MM/YYYY') + ` - (${moment(officer.dob).fromNow()})`;
                    document.getElementById('span_bio').innerText =  officer.bio;
                    document.getElementById('user_id_span').innerText = officer.id
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        } 
        fetchOfficerInformation();

        function deleteUser(){
            let userId = document.getElementById('user_id_span').innerText;

            axios.delete(`../../api/profile/delete_user.php?user_id=${userId}`, {
                headers : {
                    'Authorization' : 'Bearer ' + getToken()
                }
            })
            .then((res) => {
                if (res.data.success) {
                    alert('Record deleted successfully!')
                    location.href = 'officers.php';
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