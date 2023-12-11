<?php
   $error_code = $error_user_name = $error_first_name = $error_last_name = $error_email = $error_date_of_birth = $error_gender = $error_hobby = "";
   $arrInput = [
      [
      "code" => "Code",
      "user_name" => "Username"
      ],
      [
      "first_name" => "Firstname",
      "last_name" => "Lastname",
      ],
      [
      "email" => "Email",
      "date_of_birth" => "Date of birth"
      ],
   ];
   $rules = [
      "code" => ["required", "max:15", "regex:/^THOR000+[a-zA-Z]{1,}+[1-9]{1,}$/"],
      "user_name" => ["required", "max:20", "regex:/[^\s][^\d]$/"],
      "first_name" => ["required", "min:1", "max:255", "regex:/[^\d]$/"],
      "last_name" => ["required", "min:1", "max:255", "regex:/[^\d]$/"],
      "email" => ["required", "regex:/^[\w\-\.]+\@+[\w\-\.]+[\w]{2,4}$/"],
      "date_of_birth" => ["required", "regex:/^[\d]{2}\/[\d]{2}\/[\d]{4}/"],
   ];
   $messages = [
      "code.regex" => "The code follows the format THOR000 + [a-z] 1 characters + [1-9] 1 characters!",
      "user_name.regex" => "The username cannot contain spaces or numbers!",
      "first_name.regex" => "The first name cannot contain numbers!",
      "last_name.regex" => "The last name cannot contain numbers!",
   ];
   $removeLocalStorage = false;

   if($_SERVER['REQUEST_METHOD'] == "POST") {
      $code = $_POST['code'];
      $userName = $_POST['user_name'];
      $firstName = $_POST['first_name'];
      $lastName = $_POST['last_name'];
      $email = $_POST['email'];
      $dateOfBirth = $_POST['date_of_birth'];
      $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
      $hobby = isset($_POST['hobby']) ? $_POST['hobby'] : [];

      $flag = true;
      if(!empty($rules)){
         foreach ($rules as $name => $validator) {
            $error = 'error_' . $name;
            $nameInp = explode("_", $name)[0] ? str_replace("_", " ", $name) : $name;
            foreach ($validator as $key => $type) {
               $keyType = ! preg_match('/\:/', $type) ? $type : explode(":", $type)[0];
               $valType = ! preg_match('/\:/', $type) ? $type : explode(":", $type)[1];
               $messageErr = !empty($messages) && isset($messages[$name.'.'.$keyType]) ? $messages[$name.'.'.$keyType] : null;
               $trimData = isset($_POST[$name]) ? trim($_POST[$name]) : "";
               $data = strip_tags($trimData);
               if(! is_array($data)) {
                  if($keyType == "required") {
                     if(is_null($data) || $data == "") {
                        $$error = $messageErr ?? "The $nameInp is required!";
                        $flag = false;
                        break;
                     }
                  }
                  if($keyType == "max" || $keyType == "min") {
                     $condition = $keyType == "max" ? strlen($data) > $valType : strlen($data) < $valType;
                     if($condition) {
                        $$error = $messageErr ?? "The $nameInp " . ($keyType == "min" ?  "minimum" : "maximum") . " $valType characters!";
                        $flag = false;
                        break;
                     }
                  }
                  if($keyType == "regex") {
                     if(! preg_match($valType, $data)) {
                        $$error = $messageErr ?? "The $nameInp is not in correct format!";
                        $flag = false;
                        break;
                     }  
                  }
               }
            }
         }
      }
      if(is_null($gender) || $gender == "") {
         $error_gender = "The gender is required!";
         $flag = false;
      }elseif(! is_numeric($gender)) {
         $error_gender = "The gender must be a number!";
         $flag = false;
      }elseif(!in_array($gender, [0, 1])) {
         $error_gender = "The gender invalid!";
         $flag = false;
      }
      if(empty($hobby)) {
         $error_hobby = "The hobby is required!";
         $flag = false;
      }

      if($flag == true) {
         $removeLocalStorage = true;
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
   <div class="container form border mt-5">
      <form id="formSubmit" class="mx-4 my-4" action="index.php" method="post" autocomplete="off">
         <?php 
            foreach ($arrInput as $row) :
         ?>
         <div class="row mb-3">
            <?php 
               foreach ($row as $key => $label) :
               $error = 'error_' . $key;
               $name = preg_replace_callback('/_(\w)/', function($matches) {
                        return strtoupper($matches[1]);
                     }, $key);
               $val = isset($$name) ? $$name : "";
            ?>
               <div class="col-6">
                  <label for=""><?= $label ?> <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="<?= $key ?>" value="<?= $val ?>"> 
                  <div class="text-danger error_<?= $key ?>">
                     <?= $$error ?? "" ?>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>
         <?php endforeach; ?>
         <div class="row mb-3">
            <div class="col-6">
               <label for="">Gender <span class="text-danger">*</span></label><br>
               <input type="radio" class="" <?= isset($gender) && $gender == 0 ? "checked" : "" ?> name="gender" value="0"> Female
               <input type="radio" class="ms-2" <?= isset($gender) && $gender == 1 ? "checked" : "" ?> name="gender" value="1"> Male
               <div class="text-danger error_gender">
                  <?= $error_gender ?? "" ?>
               </div>
            </div>
            <div class="col-6">
               <label for="">Hobby <span class="text-danger">*</span></label>
               <select id="listHobbies" class="form-control" multiple name="hobby[]">
               </select>
               <div class="text-danger error_hobby">
                  <?= $error_hobby ?? "" ?>
               </div>
               <button type="button" id="addHobby" class="btn btn-success mt-2">Add hobby</button>
            </div>
         </div>
         <button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>
      </form>
   </div>

   <div class="container mt-5">
            <h2>List Users</h2>
            <table class="table">
                  <thead>
                     <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th class="text-end">Action</th>
                     </tr>
                  </thead>
                  <tbody id="listUsers">
                     
                  </tbody>
            </table>
         </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

   <script>
      $(function(){
         var selectedHobbies = [];
         localStorage.removeItem("hobbiesData")
         axios.get("http://localhost:3000/hobbies")
         .then(response => {
               const data = response.data;
               data.forEach(item => {
                  renderData(item);
               });
         })
         .catch(error => {
               console.error("Error fetching data:", error);
         });
         <?php if (!empty($hobby)) : ?>
             selectedHobbies = <?= json_encode($hobby); ?>;
             localStorage.setItem("hobbiesData", selectedHobbies);
         <?php endif; ?>
         <?php
            $arr = [];
            foreach ($arrInput as $key => $value) {
               $arr = array_merge($arr, $value);
            }
         ?>
         var arrInput = <?= json_encode(array_keys($arr)) ?>;
         var data = {code: "", userName: "", firstName: "", lastName: "", email: "", dateOfBirth: "", gender: "", hobby: []};
         arrInput.forEach(item => {
            let key = item.replace(/_(\w)/g, function(match, group){
               return group.toUpperCase();
            });
            if(Object.keys(data).includes(key)) {
               data[key] = getValInput(item);
            }
         });
         data.gender = $('input[name="gender"]:checked').val();
         data.hobby = localStorage.getItem("hobbiesData") ? localStorage.getItem("hobbiesData").split(",") : [];
         <?php if ($removeLocalStorage == true) : ?>
            axios.post('http://localhost:3000/users', JSON.stringify(data), {
               headers: {
                  'Content-Type': 'application/json'
               }
            })
            .then(res => res.json())
            .then(data => {
               const dataArr = [];
               dataArr.push(data);
               renderUsers(dataArr);
            })
            .then(() => location.reload())
            .catch(err => console.log("error", err));

            let flashMessage = `<div class="container px-3 py-2 fs-3 bg-success text-white mt-5 d-flex justify-content-between align-items-center">
               <h2>Successfully!</h2> 
               <span id="closeMessage" role="button">&#x2715</span>
            </div>`;
            let container = $('body').find('div.container.form');
            container.removeClass("mt-5");
            container.before(flashMessage);
            setTimeout(function(){
               container.prev("div").remove();
               container.addClass("mt-5");
               setTimeout(function(){
                  localStorage.clear();
                  location.replace("/index.php");
               }, 1000);
            }, 5000);
         <?php endif; ?>

         $('body').on("click", 'button[type="button"]#addHobby', function(e){
            e.preventDefault();
            if($(this).prev('input').length == 0){
               let input = $('<input />', {type: 'text', name: "addHobby", class: "form-control mt-3 mb-1"});
               let cancel = $('<button>', {type: "button", id: "btnCancel", class: "btn btn-danger mt-2 ms-2"}).text("Cancel");
               $(this).before(input);
               $(this).after(cancel);
               $(this).attr("type", "submit");
            }
         });

         $("body").on("click", "button#btnCancel", function(e){
            $('input[name="addHobby"]').remove();
            $("body").find("div#error-hobby").remove();
            $("body").find('button#addHobby').attr("type", "button");
            $(this).remove();
         });

         $("body").on("click", 'button[type="submit"]#addHobby', function(e) {
            e.preventDefault();
            let hobby = $("body").find("input[name='addHobby']");
            let error = $("<div>", {class: "text-danger my-2", id: "error-hobby"});
            error.remove();
            let flag = true;
            if(hobby.val() == "") {
               hobby.after(error.text("Hobby is reuired!"));
               flag = false;
            }
            if(flag == true) {
               fetch("http://localhost:3000/hobbies", {
                     method: 'POST',
                     headers: {
                           'Content-Type': 'application/json'
                     },
                     body: JSON.stringify({
                           name: hobby.val()
                     })
                  })
                  .then(res => res.json())
                  .then(data => {
                     const dataArr = [];
                     dataArr.push(data);
                     renderData(dataArr);
                  })
                  .then(() => location.reload());
            }
         });

         $("body").on("click", "span#closeMessage", function(e){
            let container = $('body').find('div.container.form');
            container.prev("div").remove();
            container.addClass("mt-5");
            setTimeout(function(){
               localStorage.clear();
               location.replace("/index.php");
            }, 5000);
         });

         axios.get("http://localhost:3000/users")
         .then(res => {
            console.log("success", res);
            res.data.forEach(item => {
               renderUsers(item);
            })
         }).catch(err => {console.log("error", err);})

         $("body").on("click", "tbody a.btnDelete", function(e) {
            let idUser = $(this).data('id');
            axios({
            method: 'DELETE',
            url: 'http://localhost:3000/users/' + idUser
            })
            .then(res => {
               if(res.status == 200){
                  location.reload();
               }
            })
            .catch(err => {console.log("error", err);})
         });

         $("body").on("click", "tbody a.btnEdit", function(e) {
            e.preventDefault();
            let idUser = $(this).data('id');
            axios.get('http://localhost:3000/users/' + idUser)
            .then(res => {
               arrInput.forEach(item => {
                  let key = item.replace(/_(\w)/g, function(match, group){
                     return group.toUpperCase();
                  });
                  if(Object.keys(res.data).includes(key)) {
                     $(`body input[name="${item}"]`).val(res.data[key])
                  }
               });
               console.log(res.data['gender']);
               console.log(res.data['hobby']);
               $('body input[name="gender"]').filter(`[value="1"]:checked`);
            })
            .catch(err => {console.log("error", err);})
         });
         
      });

      const getValInput = (name) => {
         return $(`input[name="${name}"]`).val();
      }

      const renderData = (data, selected = []) => {
         let hobbies = localStorage.getItem("hobbiesData");
         if(selected.length > 0){
            hobbies = selected;
         }
         const isSelected = hobbies?.length > 0 && hobbies.includes(data.id) ? 'selected' : '';
         const output = `
         <option ${isSelected} value="${data.id}">${data.name}</option>`;
         $("#listHobbies").append('beforeend', output);
      }

      const renderUsers = (data) => {
         let listUsers = $('body').find('tbody#listUsers');
         const gender = data.gender == 1 ? "Male" : "Female";
         const output = `
            <tr>
               <td>${data.id}</td>
               <td>${data.userName}</td>
               <td>${data.email}</td>
               <td>${gender}</td>
               <td class="text-end">
                  <a class="btn btn-danger btnEdit" data-id="${data.id}">Edit</a>
                  <a class="btn btn-danger btnDelete" data-id="${data.id}">Delete</a>
               </td>
            </tr>
         `;
         listUsers.append(output);
      }
   </script>
</body>
</html>