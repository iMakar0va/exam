document.getElementById("createForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const fields = form.querySelectorAll("input, textarea, select");
  const formData = new FormData(form);

  let isValid = true;
  let errors = [];

  fields.forEach((element) => {
    element.classList.remove("error");
  });
  document.getElementById("errorMessage").textContent = "";

  const date = form.date.value.trim();
  const time = form.time.value.trim();
  const weight = form.weight.value.trim();
  const dimensions = form.dimensions.value.trim();
  const addressFrom = form.address_from.value.trim();
  const addressTo = form.address_to.value.trim();
  const type = form.type.value.trim();
  const otherType = form.otherType.value.trim();

  if (!date) {
    errors.push("Введите корректную дату");
    form.date.classList.add("error");
    isValid = false;
  } else {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const selectedDate = new Date(date);
    selectedDate.setHours(0, 0, 0, 0);

    if (today >= selectedDate) {
      errors.push("Введите корректную дату");
      form.date.classList.add("error");
      isValid = false;
    }
  }
  if (!time) {
    errors.push("Введите корректное время");
    form.time.classList.add("error");
    isValid = false;
  }
  if (!weight) {
    errors.push("Введите вес груза");
    form.time.classList.add("error");
    isValid = false;
  }
  if (!dimensions) {
    errors.push("Введите габариты груза");
    form.time.classList.add("error");
    isValid = false;
  }
  if (!addressFrom) {
    errors.push("Введите адрес отправления");
    form.address_from.classList.add("error");
    isValid = false;
  }
  if (!addressTo) {
    errors.push("Введите адрес доставки");
    form.address_from.classList.add("error");
    isValid = false;
  }
  if (!type && !otherType) {
    errors.push("Введите услугу");
    if (document.getElementById("type").disabled) {
      form.otherType.classList.add("error");
    } else {
      form.type.classList.add("error");
    }
    isValid = false;
  }
  if (!isValid) {
    document.getElementById("errorMessage").innerHTML = errors.join("<br>");
    return;
  }

  fetch("php/create_application.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Вы создали заявку!");
        window.location.href = "lk.php";
      } else {
        document.getElementById("errorMessage").innerHTML = data.message;
      }
    })
    .catch((error) => {
      document.getElementById("errorMessage").innerHTML = error.message;
    });
});

document.addEventListener("DOMContentLoaded", function () {
  const type = document.getElementById("type");
  const checkbox = document.getElementById("checkbox");
  const otherType = document.getElementById("otherType");

  checkbox.addEventListener("change", function () {
    if (this.checked) {
      otherType.style.display = "block";
      type.value = "";
      type.disabled = true;
    } else {
      otherType.value = "";
      otherType.style.display = "none";
      type.disabled = false;
    }
  });
});
