var iframe = document.getElementById('loginframe');
var location = iframe.contentWindow.location;


var holder = document.createElement('div');
holder.id = 'redirect_url';
document.body.append(holder);

iframe.addEventListener('load', function (){
   location = iframe.contentWindow.location;
   document.getElementById('redirect_url').dataset.url = location;
});

