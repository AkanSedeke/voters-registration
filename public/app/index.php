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
</head>
<body>
    


    <script src="../js/store/AuthServices.js"></script>
    <script>
        
        axios.get(`../../api/auth/app.php`, { headers : {
            'Authorization' : 'Bearer ' + btoa(getCookie('access_token'))
        }})
        .then((res) => {
            console.log(res.data);
        })
        .catch((error) => {
            alert(error.response.data.message);
        })
    </script>
</body>
</html>