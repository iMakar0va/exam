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

  const namePattern = /^[А-Яа-яЁё\s]+$/;
  const phonePattern = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;

  const date = form.date.value.trim();
  const time = form.time.value.trim();
  const address = form.address.value.trim();
  const phone = form.phone.value.trim();
  const service = form.service.value.trim();
  const otherService = form.otherService.value.trim();
  const payment = form.payment.value.trim();

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
  if (!address) {
    errors.push("Введите адрес");
    form.address.classList.add("error");
    isValid = false;
  }
  if (!phonePattern.test(phone) || !phone) {
    errors.push("Введите корректный номер телефона");
    form.phone.classList.add("error");
    isValid = false;
  }
  if (!service && !otherService) {
    errors.push("Введите услугу");

    if (document.getElementById("service").disabled) {
      form.otherService.classList.add("error");
    } else {
      form.service.classList.add("error");
    }

    isValid = false;
  }
  if (!payment) {
    errors.push("Введите корректную оплату");
    form.payment.classList.add("error");
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
  const service = document.getElementById("service");
  const checkbox = document.getElementById("checkbox");
  const otherService = document.getElementById("otherService");

  checkbox.addEventListener("change", function () {
    if (this.checked) {
      otherService.style.display = "block";
      service.value = "";
      service.disabled = true;
    } else {
      otherService.value = "";
      otherService.style.display = "none";
      service.disabled = false;
    }
  });
});
