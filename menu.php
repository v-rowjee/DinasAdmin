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
  searchMenu()

  function searchMenu(){
    $.ajax({
        type:'POST',
        url:'ajax/search-menu.php',
        data:{
            search: $("#search").val(),
            category: $('#category').val()
        },
        accepts: "application/json",
        success: function(data){

            if(data.msg == "success"){   
              $('#output').html('') // reset output

              $.each(data.data, (i,item)=>{
                $('#output').append(`
                  <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="menu.php?id=${item.id}" class="card-link">
                      <div class="card card-shadow">
                        <img
                            src="images/menu/${item.img}"
                            class="card-img-top"
                            alt="${item.name}"
                        />
                        <div class="card-img-overlay">
                          <p class="item-cat">${item.category}</p>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${item.name}</h5>
                            <p class="card-text mb-2">${item.caption}</p>
                            <h6 class="price">Rs ${item.price}</h6>

                            <a href="menu.php?id=${item.id}" class="btn btn-primary">
                              Edit <i class="bx bxs-edit pt-2"></i>
                            </a>

                        </div>
                      </div>
                    </a>
                  </div>
                `)
      
              })

            }
            else if(data.msg == "error"){
              $('#output').html(`
              <div class="col align-self-center text-center">
                <img src="images/illustration-search.png" class="w-25">
                </br>
                <p class="opacity-100">No Search Result</p>
                </div>

              `)
            }
        },
        error: (xhr) => alert("Error Occured: "+xhr.status+" "+xhr.statusText) 
    });
  }

</script>

<?php include 'includes/footer.php' ?>