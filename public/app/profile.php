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
                            <a href="profile_edit.php" class="bg-secondary inline-block py-1 px-3 border border-white text-white mt-4 ml-4 text-xs rounded-lg shadow-md">
                                <i class="fas fa-edit"></i>
                                Edit Profile
                            </a>
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


                        <section id="voter_uicard" class="bg-white hidden rounded-md shadow-md overflow-hidden mb-5 px-4 py-2">
                            <h1 class="text-xl font-bold border-b border-slate-500 py-2 mb-3">
                                Voter's Info/Location
                            </h1>
                            <aside class="space-y-3">
                                <div>
                                    <strong>Voting ID: </strong> <span id="span_vote_id"></span>
                                </div>
                                <div>
                                    <strong>Contact Phone: </strong> <span id="span_vote_phone"></span>
                                </div>
                                <div>
                                    <strong>Resident Address: </strong> <span id="span_vote_address"></span>
                                </div>
                                <div>
                                    <strong>Polling_Unit: </strong> <span id="span_poll_unit"></span>
                                </div>
                                <div>
                                    <strong>Province: </strong> <span id="span_province"></span>
                                </div>
                            </aside>
                        </section>
                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_profile').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-user"></i> User Profile';

        // Add User Data to Page Elements
        document.getElementById('user_profile_image').setAttribute('src', "../" + getUser().photo);
        document.getElementById('usernames').innerText =  getUser().firstname + " " + getUser().lastname;
        document.getElementById('user_profile_role').innerText = " - " + getUser().role;
        document.getElementById('user_email').innerText =  getUser().email;
        document.getElementById('span_firstname').innerText =  getUser().firstname;
        document.getElementById('span_lastname').innerText =  getUser().lastname;
        document.getElementById('span_email').innerText =  getUser().email;
        document.getElementById('span_phone').innerText =  getUser().phone;
        document.getElementById('span_gender').innerText =  getUser().gender;
        document.getElementById('span_dob').innerText =  moment(getUser().dob).format('YYYY/DD/MM') + ` - (${moment(getUser().dob).fromNow()})`;
        document.getElementById('span_bio').innerText =  getUser().bio;

        // Function to Fetch Voters Information
        function fetchVotingInformation(){
            axios.get(`../../api/profile/vote_info.php`, {
                headers : {
                    'Authorization' : 'Bearer ' + getToken()
                }
            })
            .then((res) => {
                if (res.data.success) {
                    let voter = res.data.voter;
                    document.getElementById('span_vote_id').innerText =  voter.vote_id;
                    document.getElementById('span_vote_phone').innerText =  voter.phone;
                    document.getElementById('span_vote_address').innerText =  voter.address;
                    document.getElementById('span_province').innerText =  voter.province.name;
                    document.getElementById('span_poll_unit').innerHTML =  voter.polling_unit.punit_code + ` - <small>(${voter.polling_unit.punit_address})</small>`;
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        } 


        if (getUser().role == 'voter') {
            fetchVotingInformation();
            document.getElementById('voter_uicard').classList.remove('hidden');
        }
    </script>
</body>
</html>