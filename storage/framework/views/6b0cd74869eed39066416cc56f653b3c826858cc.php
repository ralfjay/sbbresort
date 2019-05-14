<footer class="section footer-section" style="padding: 2em 0">
    <div class="container">
      <div class="row pt-1">
        <p class="col-md-8 text-left" style="color: white!important;">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Sigayan Bay Beach Resort
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </p>
        <div>
          <span style="color: white;"><span class="fa fa-phone" style="color: white;"></span> Contact Us: 
          <?php
          $x = 1;
          $limit = count(Request::session()->get('resort_contact_number'));
          ?>

          <?php $__currentLoopData = Request::session()->get('resort_contact_number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact_number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($contact_number->contact_number); ?> &nbsp; 
              <?php if($x < $limit): ?> 
              | &nbsp;
                <?php $x++ ?>
              <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></span>&nbsp;
          
        </div>
        <div>
          <span style="color: white;">
            <span style="color: white;" class="fa fa-envelope"></span> 
            E-mail: <?php echo e(Request::session()->get('resort_email')[0]['email']); ?>

          </span>
        </div>
      </div>
    </div>
</footer>