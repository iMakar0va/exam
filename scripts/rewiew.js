document.getElementById("rewiewForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const fields = form.querySelectorAll("textarea");

  let isValid = true;
  let errors = [];

  fields.forEach((element) => {
    element.classList.remove("error");
  });
  document.getElementById("errorMessage").textContent = "";

  const appId = form.app_id.value;
  const rewiew = form.rewiew.value.trim();

  if (!rewiew) {
    errors.push("Введите корректную отзыв");
    form.payment.classList.add("error");
    isValid = false;
  }
  if (!isValid) {
    document.getElementById("errorMessage").innerHTML = errors.join("<br>");
    return;
  }

  fetch("php/insert_rewiew.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      app_id: appId,
      rewiew: rewiew,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Вы оставили отзыв!");
        window.location.href = "lk_past.php";
      } else {
        document.getElementById("errorMessage").innerHTML = data.message;
      }
    })
    .catch((error) => {
      document.getElementById("errorMessage").innerHTML = error.message;
    });
});
