<?php
include("includes/includedFiles.php");
?>

<section class="contact">
  <h2>Hey! feel free to tell me wants on your mind....</h2>
  <form action="#">
    <div class="input-box">
      <div class="input-field field">
        <input type="text" placeholder="Full Name" id="name" class="item" autocomplete="off">
        <div class="error-txt">Full Name can't be blank</div>
      </div>
      <div class="input-field field">
        <input type="text" placeholder="Email Address" id="email" class="item" autocomplete="off">
        <div class="error-txt email">Email Address can't be blank</div>
      </div>
    </div>

    <div class="input-box">
      <div class="input-field field">
        <input type="text" placeholder="Phone Number" id="phone" class="item" autocomplete="off">
        <div class="error-txt">Phone Number can't be blank</div>
      </div>
      <div class="input-field field">
        <input type="text" placeholder="Subject" id="subject" class="item" autocomplete="off">
        <div class="error-txt">Subject can't be blank</div>
      </div>
    </div>

    <div class="textarea-field field">
      <textarea name="" id="message" cols="30" rows="10" placeholder="Type in your message here..." class="item"
        autocomplete="off"></textarea>
      <div class="error-txt">Message can't be blank</div>
    </div>

    <button type="submit">Send Message</button>
  </form>
</section>

<script src="https://smtpjs.com/v3/smtp.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const form = document.querySelector("form");
  const fullName = document.getElementById("name");
  const email = document.getElementById("email");
  const phone = document.getElementById("phone");
  const subject = document.getElementById("subject");
  const mess = document.getElementById("message");
  function sendEmail() {
    const bodyMessage = `Full Name: ${fullName.value}<br> Email: ${email.value}<br> Phone Number: ${phone.value}<br> Message: ${mess.value}`;
    Email.send({
      // SecureToken: "c68ddcc9-32fe-4102-aeb3-787e02463b33",
      Host: "smtp.elasticemail.com",
      Username: "ndunwa240@gmail.com",
      Password: "43806170B47A3A194642E95E1F7F2FD13668",
      To: "ndunwa240@gmail.com",
      From: "ndunwa240@gmail.com",
      Subject: "From iLoveMusic: " + subject.value,
      Body: bodyMessage,
    }).then((message) => {
      if (message == "OK") {
        Swal.fire({
          title: "Success!",
          text: "Message sent successfully!",
          icon: "success",
          background: 'black',
          color: 'white',
          confirmButtonColor: '#FFA500',
          showClass: {
            popup: 'swal2-show'
          },
          customClass: {
            popup: 'custom-border'
          }
        });
      }
    });
  }
  function checkInputs() {
    const items = document.querySelectorAll(".item")
    for (const item of items) {
      if (item.value == "") {
        item.classList.add("error");
        item.parentElement.classList.add("error");
      }
      if (items[1].value != "") {
        checkEmail();
      }
      items[1].addEventListener("keyup", () => {

      });
      item.addEventListener("keyup", () => {
        if (item.value != "") {
          item.classList.remove("error");
          item.parentElement.classList.remove("error");
        } else {
          item.classList.add("error");
          item.parentElement.classList.add("error");
        }
      });
    }
  }
  function checkEmail() {
    const emailRegex = /^([a-z\d\.-]+)([a-z\d-]+)\.([a-z]{2,3})(\.[a-z]{2,3})?$/;
    const errorTxtEmail = document.querySelector(".error-txt.email");
    if (email.value.match(emailRegex)) {
      email.classList.add("error");
      email.parentElement.classList.add("error");

      if (email.value != "") {
        errorTxtEmail.innerText = "Enter a valid email address";
      } else {
        errorTxtEmail.innerText = "Email Address can't be blank";
      }
    } else {
      email.classList.remove("error");
      email.parentElement.classList.remove("error");
    }
  }
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    checkInputs();

    if (!fullName.classList.contains("error") && !email.classList.contains("error") && !phone.classList.contains("error") && !subject.classList.contains("error") && !mess.classList.contains("error")) {
      sendEmail();

      form.reset();
      return false;
    }
  });

</script>