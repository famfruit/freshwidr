<div class="orderBar help">
      <span class="id"><?php echo $row['ID']?></span>
      <span class="type <?php echo $row['type']?>"><?php echo $row['type']?></span>
      <span><?php echo $row['url_tag']?></span>
      <span><?php echo $row['descr']?></span>
      <div class="clAb">  </div>
      <div class="addInfo hidden">

        <div class="textcontent" contenteditable="true">

                  <?php
                  $string = $row['text'];
                  ?>
                  <xmp><?php echo $string; ?></xmp>


        </div>
        <div class="save">
          Spara
        </div>
      </div>
</div>
