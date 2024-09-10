
<?php $isBought = $isMyCourse ? false : $isBought; ?>
<div <?php echo 'class="flex-row course-item no-select '.($isMyCourse ? "my-course" : "").'"'; ?>>
    <div class="flex-column flex-align-center flex-justify-center av-container">
        <div class="flex flex-align-center flex-justify-center pt-av-cont">
            <img <?php echo 'src="'.($user->immagine == null ? './Immagini/default-user.png' : $user->immagine).'"'; ?> class="pt-avatar-img" alt="personal trainer's avatar">
        </div>
        <div class="flex pt-name"><?php echo $user->nome." ".$user->cognome; ?></div>
    </div>
    <div class="flex-column couse-item-info">
        <div class="flex-align-center course-name"><?php echo $c["Nome"]; ?></div>
        <div class="flex-align-center course-desc"><?php echo $c["Descrizione"]; ?></div>
    </div>
    <div class="flex-column flex-align-center flex-justify-center course-btn-cont">
        <button class="flex-row flex-align-center flex-justify-center course-item-btn" <?php echo 'data-course-id="'.$c["Id"].'"'; echo $isBought ? 'disabled=true' : ''; ?>><?php echo $isBought ? 'Corso acquistato' : 'Entra nel corso'; ?></button>
        <?php echo $isBought ? '' : '<div class="flex course-price">'.$c["Prezzo"].' €'.'</div>'; ?>
    </div>
</div>
