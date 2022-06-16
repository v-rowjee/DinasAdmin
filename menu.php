<?php 
$active= 'menu';
include 'includes/header.php';

if(isset($_GET['id'])){
  if($_GET['id'] == 'new')
    include 'includes/menu_new.php';
  else
    include 'includes/menu_edit.php';
}else{
  
?>
  <!--Container Main start-->
  <div class="container py-3">
    <div class="d-flex align-items-center align-middle">
      <h2 class="me-auto">Menu</h2>
      <!-- SEARCH BAR -->
      <form class="flex-row-reverse">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search item" id="search" onkeyup="searchMenu()">
          <button type="button" class="input-group-text">
            <i class='bx bx-search'></i>
          </button>
        </div>

        <select class="form-select me-3" style="width: 150px;" id="category" onchange="searchMenu()">
          <option value="%" selected>All Category</option>
          <option value="starter">Starter</option>
          <option value="pasta">Pasta</option>
          <option value="pizza">Pizza</option>
          <option value="dessert">Dessert</option>
          <option value="drinks">Drink</option>
        </select>

        <a href="menu.php?id=new" class="input-group-text me-3">
          <i class="bx bx-plus"></i>
        </a>
      </form>
              
    </div>

    <!-- ITEMS -->
    <div class="row g-4 mt-3" id="output"></div>
    
  </div>
  <!--Container Main end-->
<?php } ?>

<script>
  searchMenu();

  function searchMenu(){
    $.ajax({
        type:'POST',
        url:'ajax/search-menu.php',
        data:{
            search: $("#search").val(),
            category: $('#category').val()
        },
        success:function(data){
            $("#output").html(data);
        }
    });
  }

</script>

<?php include 'includes/footer.php' ?>