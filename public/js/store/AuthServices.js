function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteCookie(cname){
    document.cookie = cname + "=" + "expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
 
function saveToken(accessToken) {
    // Update Axios Instance with access token
    axiosIns = window.axios;
    window.axios.interceptors.request.use(async config => {
        if (config.headers) {
            config.headers.Authorization = `Bearer ${accessToken}` 
            localStorage.setItem('access_token', accessToken);
        }
        console.log(accessToken);
        return config
    });
    // window.axios = axiosIns;
    setCookie('access_token', btoa(accessToken), 2);
}

function deleteToken(accessToken) {
    // Update Axios Instance with access token
    axiosIns = window.axios;
    axiosIns.interceptors.request.clear()
    window.axios = axiosIns;
    deleteCookie('access_token');
}

function storeUser(user){
    localStorage.setItem('user', JSON.stringify(user));
}

function getUser(){
    return JSON.parse(localStorage.getItem('user'));
}