<?php 

$role = $_GET['role'];
$id_nguoiDung=$_GET['idnguoidung'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TRANG CREATE PROJECT.HTML</title>
    <script
      src="https://kit.fontawesome.com/901acbd329.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <nav class="navigation">
      <ul class="nav_ul">
        <div class="nav_ul_left">
          <li><i class="fa-solid fa-bars"></i></li>
          <li>Test</li>
        </div>
        <div class="nav_ul_right">
          <li style="width: 200px;color:yellow" >
          Role: <?php if ($role == 1) {
    echo " Người gán nhãn cấp 1";
} elseif ($role == 2) {
    echo " Người gán nhãn cấp 2";
} elseif ($role == 3) {
    echo "Quản lý";
} ?> 
        
        </li>
          <li><i class="fa-solid fa-sun"></i></li>

          <li>ENV<i class="fa-sharp fa-solid fa-caret-down"></i></li>
          <li>PROJECTS</li>
          <li><i class="fa-solid fa-bars"></i></li>
          <li></li>
        </div>
      </ul>
    </nav>

    <div class="NavContent_right" style="width: 100%">
      <div class="NavContent_right_btn">
     
        <button class="NavContent_Left_Btn" id="createButton" style="width: 100px; <?php echo ($role != 3) ? 'cursor:not-allowed;' : ''; ?>" 
         > Create
        

          
        </button>
        <button
        class="btn_delete"
          style="
            width: 80px;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;  background-color: red;
            <?php echo ($role != 3) ? 'cursor:not-allowed' : ''; ?>"
        >
          Delete
        </button>
        <div class="NavContent_right_search">
          <div class="NavContent_right_search_top">
            <i class="fa-solid fa-magnifying-glass"></i>Search
          </div>
          <div class="NavContent_right_search_top_left">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th >Type</th>
                </tr>
              </thead>
              <tbody>
                
              <?php
            // Đường dẫn tới file Controller
            require_once '../Controller/Project_Controller.php';

            // Khởi tạo đối tượng của Controller
            $projectController = new ProjectController();


            if ($role == 3) {
              // Gọi phương thức lấy tất cả các projects
              $projects = $projectController->getAllProject();
          } else {
              $projects=$projectController->getUserProject($id_nguoiDung);
          }

            
            ?>
            <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?php echo $project['tenDuAn']; ?></td>
                        <td><?php echo $project['moTa']; ?></td>
                        <td><?php echo $project['TenLoai']; ?></td>
                        <td class="taskLinks">
                        <a href="../View/Labeling.php?action=all&idnguoidung=<?php echo $id_nguoiDung; ?>&idDuAn=<?php echo $project['ID_DuAn']; ?>&role=<?php echo $role; ?>">Nhãn</a>
                        
                        </td>
                    </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                  <td style="text-align: center">No data available</td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="NavContent_Right_bottom">
          Rows Per Page
          <select>
            <!-- <option  value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option> -->
            <option selected value="10">10</option>
          </select>
          1-4 of 4
          <div class="Nav_bottom_icon">
            <i class="fa-solid fa-angles-left"></i>
            <i class="fa-solid fa-arrow-left"></i>
            <i class="fa-solid fa-arrow-right"></i>
            <i class="fa-solid fa-angles-right"></i>
          </div>
        </div>
      </div>
    </div>
    <div></div>
  </body>
  <script src="./index.js"></script>

  <link rel="stylesheet" href="./CSS/CreateProject.css" />
</html> 
</html>

<script>
  const createButton = document.getElementById('createButton');

// Thêm sự kiện click vào button "Create"
createButton.addEventListener('click', function() {
  // Tạo một div chứa form tạm thời
  const formContainer = document.createElement('div');
  formContainer.classList.add('form-container'); // Thêm class cho div nếu cần thiết

  // Tạo HTML cho form tạm thời
  const formHTML = `
  <style>
  .form-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f8f8f8;
  border-radius: 5px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
select,
textarea {
  width: 100%;
  padding: 8px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

button[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #428bca;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #45a049;
}
  </style>

  <form id="temporaryForm" method = "POST" class="form-container" action = "../Controller/Project_Controller.php" name="createProject">  
  <h2>Tạo dự án mới</h2>

  <div class="form-group">
    <label for="projectName">Tên dự án:</label>
    <input type="text" id="projectName" name="projectName" required>
  </div>

  <div class="form-group">
    <label for="projectType">Loại dự án:</label>
    <select id="projectType" name="projectType1" required>
      <option value="">-- Chọn loại dự án --</option>
      <option value=1>Phân loại văn bản</option>
      <option value=2>Hỏi đáp</option>
      <option value=3>Dịch máy</option>
      <option value=4>Gán nhãn thực thể</option>
      <option value=5>Gán nhãn câu trả lời của cặp câu hỏi và văn bản</option>
      <option value=6>Tìm câu hỏi đồng nghĩa</option>
    </select>
  </div>

  <div class="form-group">
    <label for="projectDescription">Mô tả:</label>
    <textarea id="projectDescription" name="projectDescription1" required></textarea>
  </div>

  <div class="form-group">
    <button type="submit" name="createProject">Tạo dự án</button>
  </div>
</form>
  `;

  // Gán HTML của form vào div
  formContainer.innerHTML = formHTML;

  // Thêm div chứa form vào trang
  document.body.appendChild(formContainer);

  // Lưu ý: Bạn có thể chỉnh sửa các trường và nút trong formHTML theo yêu cầu của bạn

  // Tùy chỉnh CSS cho form tạm thời nếu cần thiết
  formContainer.style.position = 'fixed';
  formContainer.style.top = '50%';
  formContainer.style.left = '50%';
  formContainer.style.transform = 'translate(-50%, -50%)';
  formContainer.style.backgroundColor = 'white';
  formContainer.style.padding = '20px';
  formContainer.style.border = '1px solid gray';
  formContainer.style.zIndex = '9999';

  // Gán sự kiện submit cho form tạm thời
  const temporaryForm = document.getElementById('temporaryForm');
  temporaryForm.addEventListener('submit', function(event) {
   // event.preventDefault();
    //var projectDescription = document.getElementById('projectDescription').value;
    //echo(projectDescription);
    // Xử lý dữ liệu từ form tạm thời tại đây
    // Sau khi xử lý, bạn có thể xóa form tạm thời bằng cách sử dụng formContainer.remove();
    //formContainer.remove();
  });
});








  </script>