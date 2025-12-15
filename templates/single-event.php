<?php

defined( 'ABSPATH' ) || exit;


get_header();
?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                <h1> <?php the_title() ?> </h1>
                <div>
                    <?php    $cities = get_the_terms(get_the_ID(), 'city');

                          if ($cities && !is_wp_error($cities)) :
                            
                            foreach($cities as $city){
                                echo $city->name.',';
                            }
                   endif;

                    ?>
                </div>
                <div> <?php the_field('opis_event') ?></div>
                




                <div>
                    <?php     
                     the_field('data_event') ?> 
                </div>


                <div>
                    <?php  
                        $post_id = get_the_id();
                        $zapisani = get_post_meta($post_id,'event_registrations',true);
                        if(!empty($zapisani)){
                            echo '<span id="current-cout">'.count($zapisani) .'</span> / ';
                        }else{
                            echo '<span id="current-cout">0 / </span>';
                        }

                        the_field('limit_event');
                    ?>

                </div>
                
                <div>

                    <?php 
                    
                    $user_id = get_current_user_id();
                    
                    function CzyZapisany($zapisani,$user_id){
                         if(is_array($zapisani)){
                        foreach($zapisani as $zapisany){
                            if($zapisany['user_id'] == $user_id){
                                return $zapisany = true;
                            }
                        }
                        return $zapisany = false;

                    }
                }

                $zapisany = CzyZapisany($zapisani,$user_id) || false;
                

                

                    


                    if(is_user_logged_in()  && !$zapisany):
                        ?>

                       <form id="dl_formularz_zapisu" method="post" class="needs-validation pt-4" novalidate>
                            <h2>Zapisz się!</h2>
                            <div class="mb-3">
                                <label for="dl-name" class="form-label">Imię</label>
                                <input
                                    type="text"
                                    id="dl-name"
                                    name="name"
                                    class="form-control"
                                    required
                                >
                                <div class="invalid-feedback">
                                    Podaj imię
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dl-email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    id="dl-email"
                                    name="email"
                                    class="form-control"
                                    required
                                >
                                <div class="invalid-feedback">
                                    Podaj poprawny email
                                </div>
                            </div>

                    
                            <input
                                type="hidden"
                                id="dl-form-nonce"
                                name="nonce"
                                value="<?php echo esc_attr( wp_create_nonce('dl_register_nonce') ); ?>"
                            >

                         
                            <input
                                type="hidden"
                                id="dl-post-id"
                                name="post_id"
                                value="<?php echo esc_attr( get_the_ID() ); ?>"
                            >

                            <button
                                type="submit"
                                id="my-submit"
                                class="btn btn-primary"
                            >
                                Zapisz
                            </button>

                        </form>


                        <?php endif;
                        
                        if(is_user_logged_in() && $zapisany):
                    ?>

                    <h2>Jestes juz zapisany</h2>
                            
                    <?php endif; ?>

                      
                    <?php if(!is_user_logged_in()): ?>

                        <h2> Zaloguj się by móc się zapisać </h2>

                    <?php endif; ?>    

                        


                </div>

            </div>
        </div>
    </div>    
</main>



<?php
get_footer();