const btnAccount = document.getElementById("btn-account");
const accountMenu = document.getElementById("account-menu");

if (btnAccount) {
  btnAccount.addEventListener("click", function () {
    accountMenu.classList.toggle("hidden");
  });
}

function previewKarya(event) {
  const fileType = event.target.files[0].type;
  const previewDiv = document.getElementById("preview-gambar");
  previewDiv.innerHTML = "";

  if (fileType.includes("image")) {
    let imgUrl = URL.createObjectURL(event.target.files[0]);
    const imgElement = document.createElement("img");

    previewDiv.innerHTML = "";
    imgElement.src = imgUrl;
    imgElement.classList.add("h-auto", "w-full", "md:w-auto", "md:h-[360px]", "aspect-video");
    previewDiv.appendChild(imgElement);
  }
}
