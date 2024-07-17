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
                                    <a href="officers.php" class="py-1 px-3 bg-primary text-sm font-semibold text-white rounded-lg inline-block">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </header>

                            <!-- Polling Units Table Section -->
                            <section class="px-4 py-2 bg-white rounded-xl shadow-md">
                                <div class="flex items-start justify-between gap-5 mb-4">
                                    <h1 class="font-bold underline">
                                        Add Officer
                                    </h1>
                                </div>

                                <form id="form_add_officer">
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="text" name="firstname" required placeholder="Enter Firstname" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-user"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="text" name="lastname" required placeholder="Enter Lastname" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-user"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="email" name="email" required placeholder="Enter Email Address" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="tel" name="phone" placeholder="Enter Phone Number" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-phone"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <select name="gender" name="lastname" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" >
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-user"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="date" name="dob" placeholder="Date of Birth" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <!-- <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-calendar"></i>
                                            </button> -->
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex items-center max-w-full bg-slate-50 rounded-md border">
                                            <input type="file" name="profile_image" placeholder="Upload Profile Image" class="flex-grow bg-transparent py-2 px-3 focus:outline-none focus:border-none focus:ring-0 active:border-none active:ring-0" />
                                            <button type="button" class='px-3 text-slate-500 font-semibold'>
                                                <i class="fas fa-image"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn-primary w-full justify-center gap-1 rounded-md h-9 text-white">
                                            <i class="fa fa-plus"></i> Add Officer
                                        </button>
                                    </div>
                                </form>
                            </section>
                        </aside>

                    </div>
                </main>
            </section>
        </section>
    </div>



    <script>
        document.getElementById('mnu_officers').classList.add('active');
        document.getElementById('page_title').innerHTML = '<i class="fas fa-poll"></i> Add Polling Units';

        document.getElementById('form_add_officer').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(event.target);
            axios.post(`../../api/voter/add_officer.php`, formData)
            .then((res) => {
                if (res.data.success) {
                    alert(res.data.message);
                    event.target.reset();
                    location.href = 'officers.php';
                } else {
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                alert(error.response.data.message);
            })
        })
    </script>
</body>
</html>