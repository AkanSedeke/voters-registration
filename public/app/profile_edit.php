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
                    <div class="mb-5">
                        <a href="profile.php" class="bg-primary inline-block py-1 px-3 border border-white text-white mt-4 ml-4 text-xs rounded-lg shadow-md">
                            <i class="fas fa-arrow-left"></i>
                            BACK
                        </a>
                    </div>
                    <div class="mb-8">
                        <form id="form_user_profile">
                            <section class="bg-white rounded-md shadow-md overflow-hidden mb-5 px-4 py-2">
                                <h1 class="text-xl font-bold border-b border-slate-500 py-2 mb-3">
                                    User Bio
                                </h1>
                                <aside class="gap-3 grid grid-cols-1 md:grid-cols-2">
                                    <div>
                                        <strong>Profile Image: </strong> <br>
                                        <input type="file" name="profile_image" placeholder="Upload Profile Image" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" accept="image/*" />
                                    </div>
                                    <div>
                                        <strong>Firstname: </strong> <br>
                                        <input type="text" name="firstname" required placeholder="Enter Firstname" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Lastname: </strong> <br>
                                        <input type="text" name="lastname" required placeholder="Enter Lastname" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Email: </strong> <br>
                                        <input type="text" name="email" required placeholder="Enter Email Address" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Phone: </strong> <br>
                                        <input type="text" name="phone" placeholder="Enter Phone Number" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Gender: </strong> <br>
                                        <select name="gender" class="flex-grow w-full h-8 bg-transparent py-2 px-3 border outline-none ring-0">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div>
                                        <strong>Date of Birth: </strong> <br>
                                        <input type="date" name="dob" placeholder="Date of Birth" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>About (Bio): </strong> <br>
                                        <input type="text" name="bio" placeholder="Enter Bio" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <button class="btn-primary justify-center gap-1 rounded-md h-9 text-white">
                                            <i class="fa fa-plus"></i> Save Information
                                        </button>
                                    </div>
                                </aside>
                            </section>
                        </form>
                    </div>

                    <div id="voter_uicard" class="mb-8 hidden">
                        <form id="voter_form">
                            <section class="bg-white rounded-md shadow-md overflow-hidden mb-5 px-4 py-2">
                                <h1 class="text-xl font-bold border-b border-slate-500 py-2 mb-3">
                                    Voter's Location
                                </h1>
                                <aside class="gap-3 grid grid-cols-1 md:grid-cols-2">
                                    <div>
                                        <strong>Voter ID: </strong> <br>
                                        <input type="text" name="voter_id" readonly placeholder="Voter ID" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Contact Phone: </strong> <br>
                                        <input type="text" name="vote_phone" required placeholder="Enter Contact Phone" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Address: </strong> <br>
                                        <input type="text" name="vote_address" required placeholder="Enter Resident Address" class="flex-grow w-full bg-transparent py-1 px-3 border outline-none ring-0" />
                                    </div>
                                    <div>
                                        <strong>Province: </strong> <br>
                                        <select name="vote_province" id="vote_province" class="flex-grow w-full h-8 bg-transparent py-2 px-3 border outline-none ring-0">
                                            <option value="">Select Province</option>
                                        </select>
                                    </div>
                                    <div>
                                        <strong>Polling Unit: </strong> <br>
                                        <select name="poll_unit" id="poll_unit" class="flex-grow w-full h-8 bg-transparent py-2 px-3 border outline-none ring-0">
                                            <option value="">Select Polling Unit</option>
                                        </select>
                                    </div>
                                    <div>
                                        <strong> &nbsp; </strong> <br>
                                        <button class="btn-primary justify-center gap-1 rounded-md h-9 text-white">
                                            <i class="fa fa-plus"></i> Save Information
                                        </button>
                                    </div>
                                </aside>
                            </section>
                        </form>
                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_profile').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-user"></i> Edit User Profile';

        document.querySelector('[name=firstname]').value =  getUser().firstname;
        document.querySelector('[name=lastname]').value =  getUser().lastname;
        document.querySelector('[name=email]').value =  getUser().email;
        document.querySelector('[name=phone]').value =  getUser().phone;
        document.querySelector('[name=gender]').value =  getUser().gender;
        if (getUser().gender) {
            document.querySelector(`option[value=${getUser().gender}]`).setAttribute('selected', true);
        }
        document.querySelector('[name=dob]').value =  moment(getUser().dob).format('YYYY-DD-MM');
        document.querySelector('[name=bio]').value =  getUser().bio;

        document.getElementById('form_user_profile').addEventListener('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(event.target);
            axios.post(`../../api/profile/update.php`, formData, {
                headers : {
                    'Authorization' : 'Bearer ' + getToken()
                }
            })
            .then((res) => {
                if (res.data.success) {
                    alert(res.data.message);
                    storeUser(res.data.user); // Update user records
                    event.target.reset();
                    location.reload();
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        })

        function fetchVotingInformation(){
            axios.get(`../../api/profile/vote_info.php`, {
                headers : {
                    'Authorization' : 'Bearer ' + getToken()
                }
            })
            .then((res) => {
                if (res.data.success) {
                    let voter = res.data.voter;
                    document.querySelector('[name=voter_id]').value =  voter.vote_id;
                    document.querySelector('[name=vote_phone]').value =  voter.phone;
                    document.querySelector('[name=vote_address]').value =  voter.address;
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
            // Submit the form on submit event
            document.getElementById('voter_form').addEventListener('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(event.target);
            axios.post(`../../api/profile/vote_info_update.php`, formData, {
                headers : {
                    'Authorization' : 'Bearer ' + getToken()
                }
            })
            .then((res) => {
                if (res.data.success) {
                    alert(res.data.message);
                    location.reload();
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        })
        }

        function fetchProvince(){
            axios.get(`../../api/pollunit/fetch_province.php`)
            .then((res) => {
                if (res.data.success) {
                    let provincesHtml = '<option value="">Select Province</option>';
                    let provinces = res.data.provinces;
                    provinces.forEach((province) => {
                        provincesHtml += `<option value="${province.id}">
                                ${province.province}
                            </option>`;
                    });
                    document.getElementById('vote_province').innerHTML = provincesHtml;
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        }
        fetchProvince();

        // Fetch Polling Units on change event of the province select input
        document.getElementById('vote_province').addEventListener('change', function(event) {
            let province_id = event.target.value;
            axios.get(`../../api/pollunit/fetch_units.php?province_id=${province_id}`)
            .then((res) => {
                let pollUnitHTML = '';
                if (res.data.success) {
                    let fetchUnits = res.data.units;
                    if (fetchUnits.length > 0) { // If the records are more than zero(0)
                        pollUnitHTML += '<option value="">Select Polling Unit</option>'; // retain the first option
                        fetchUnits.forEach((pollingUnit, index) => {
                        pollUnitHTML += `<option value="${pollingUnit.id}">
                                ${pollingUnit.punit_code} - ${pollingUnit.punit_address}
                            </option>`;
                        })
                    } else {
                        // If there is no record
                        pollUnitHTML += `<option value="">
                                No Polling Unit record found in selected province
                            </option>`;
                    }
                    
                }
                document.getElementById('poll_unit').innerHTML = pollUnitHTML;
            })
        })
    </script>
</body>
</html>