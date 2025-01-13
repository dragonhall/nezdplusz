const urlParams = new URLSearchParams(window.location.search);
const rcts = urlParams.get("rcts");

if(typeof(rcts) == 'undefined' || rcts === null) {
  window.location.href = "https://dragonhall.hu/nezdplusz/figyucsak.php";
}
