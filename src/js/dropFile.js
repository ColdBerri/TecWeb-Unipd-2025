const immagine = document.getElementById("immagine");
const fileInfo = document.getElementById("file-info");

function formatSize(bytes) {
  if (bytes < 1024) return `${bytes} B`;
  if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
  return `${(bytes / (1024 * 1024)).toFixed(2)} MB`; //POrc era * ...
}

immagine.addEventListener("change", function () {
  const files = immagine.files;
  
  if (files.length === 0) {
    fileInfo.textContent = "Nessun file selezionato.";
    return;
  }

  let output = "<ul>";
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    output += `<li>${file.name} - ${formatSize(file.size)}</li>`;
  }
  output += "</ul>";

  fileInfo.innerHTML = output;
});