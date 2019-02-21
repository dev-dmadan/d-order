<?php Defined("BASE_PATH") or die(ACCESS_DENIED); ?>

<!-- Modal View Item -->
<div class="modal fade" id="modal-view-item" role="dialog" aria-labelledby="modal-view-itemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-view-itemLabel">View Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="view-item">
                <input type="hidden" id="id">
                <div class="modal-body">
                    <div class="row">
                        <!-- grid span 12 -->
                        <div class="col-md-6 col-xs-12">
                            <div class="user-item">
                                <!-- user image -->
                                <img alt="image" src="http://memoriacode.com/image/ayam.jpg" width="80%" class="rounded-circle mr-1">
                                <div class="user-details">
                                    <div class="food-name">Ayam Di Madu<!-- <?= $_SESSION['sess_name'] ?> --></div>
                                    <div class="text-job text-muted">Cafetaria Assakinah<!-- <?= $_SESSION['sess_level'] ?> --><br><br></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="category"><strong>Category</strong></label>
                                <div class="user-category"><!-- <?= $_SESSION['sess_email'] ?> -->Paket Ayam Hemat</div>
                            </div>

                            <div class="form-group">
                                <label for="price"><strong>Price</strong></label>
                                <div class="user-price">Rp <!-- <?= $_SESSION['sess_email'] ?> -->25.000,00</div>
                            </div>

                            <div class="form-group">
                                <label for="rating"><strong>Rating</strong></label>
                                <div class="user-rating"><!-- <?= $_SESSION['sess_email'] ?> -->4.8 <img alt="image" src="http://memoriacode.com/image/star.png" width="5%"></div>
                            </div>

                            <div class="form-group">
                                <label for="description"><strong>Description</strong></label>
                                <div class="user-description"><!-- <?= $_SESSION['sess_email'] ?> -->Nasi + Ayam Bakar with Honey + Tempe & Tahu Goreng + Salad + Sambal</div>
                            </div>

                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>