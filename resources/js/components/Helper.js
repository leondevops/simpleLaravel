
function zeroPadding(number, amount){
    return String(number).padStart(amount, '0');
}

function getRandomString(length){
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for ( var i = 0; i < length; i++ ) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
    return result;
}

/* function editTaskTitle(event){

} */


export default {zeroPadding, getRandomString};
