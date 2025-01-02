<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = "";
}
?>

<div class="searchContainer">
    <h4>Search for an artist, album or song</h4>
    <input 
        type="text" 
        class="searchInput" 
        value="<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>" 
        placeholder="Start typing..." 
        autocomplete="off"
    >
</div>
<script>
$(document).ready(function() {
    // Store input position before refresh
    $('.searchInput').on('input', function() {
        let cursorPosition = this.selectionStart;
        localStorage.setItem('searchInputPosition', cursorPosition);
    });

    // Set initial focus
    $('.searchInput').focus();
    
    // Restore cursor position
    let savedPosition = localStorage.getItem('searchInputPosition');
    if (savedPosition !== null) {
        let input = $('.searchInput')[0];
        input.setSelectionRange(savedPosition, savedPosition);
    }

    // Handle search with debounce
   
    $('.searchInput').on('input', function() {
        
        let input = $(this);
        timer = setTimeout(function() {
            let val = input.val();
            // Store current value before refresh
            localStorage.setItem('searchInputValue', val);
            
            // Navigate to search page
            window.location.href = 'search.php?term=' + encodeURIComponent(val);
        }, 1000);
    });
});
</script>





<?php if($term == "") exit(); ?>
<div class="tracklistContainer borderbottom">
    <h2>Songs</h2>
    <ul class="tracklist">
        <?php
        $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
        if(mysqli_num_rows($songsQuery) == 0) {
            echo "<span class='noResults'>No songs found matching " . $term . "</span>";
        }
        $songIdArray = array();
        $i = 1;
        while($row = mysqli_fetch_array($songsQuery)) {
            if($i > 15) {
                break;
            }
            array_push($songIdArray, $row['id']);
            $albumSong = new Song($con, $row['id']);
            $albumArtist = $albumSong->getArtist();
            // I added song image
            $albumImage = $albumSong->getAlbum()->getArtworkPath();

            echo "<li class='tracklistRow'>
                <div class='trackCount'>
                    <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"". $albumSong->getId() ."\", tempPlaylist, true)'>
                    <span class='trackNumber'>$i</span>
                </div>

                <div class='trackImage'>
                    <img class='songImage' src=\"" . $albumImage . "\"> 
                </div>

                <div class='trackInfo'>
                    <span class='trackName'>" .$albumSong->getTitle(). "</span>
                    <span class='artistkName'>" .$albumArtist->getName(). "</span>
                </div>

                <div class='trackOptions'>
                    <img class='optionsButton' src='assets/images/icons/more.png'>
                </div>

                <div class='trackDuration'>
                    <span class='duration'>" . $albumSong->getDuration(). "</span>
                </div>
            </li>";
            $i++;
        }
        ?>
        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
            console.log(tempPlaylist);
        </script>
    </ul>
</div>

<div class="artistsContainer borderBottom">
        <h2>Artists</h2>
        <?php
        $artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");
        if(mysqli_num_rows($artistQuery) == 0) {
            echo "<span class='noResults'>No artist found matching " . $term . "</span>";
        }
        while($row = mysqli_fetch_array($artistQuery)) {
            $artistFound = new Artist($con, $row['id']);
            echo "<div class='searchResultRow'>
                    <div class='artistImage' role='link' tabindex='0' onclick='openPage(\"artist.php?id=". $artistFound->getId() ."\")'>
                        <img src=\"" . $artistFound->getImage() . "\"> 
                    </div>        
                    <div class='artistName'>
                        <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=". $artistFound->getId() ."\")'>
                        "
                        . $artistFound->getName() .
                        "
                        </span>
                    </div>
                </div>";
        }
        ?>
</div>

<div class="gridViewContainer">
    <h2>Albums</h2>
    <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");
    if(mysqli_num_rows($albumQuery) == 0) {
        echo "<span class='noResults'>No albums found matching " . $term . "</span>";
    }
    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "
                <div class='gridViewItem'>
                        <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                        <img src='" . $row['artworkPath'] . "'>
                    <div class='gridViewInfo'>" . $row['title'] . "</div>
                    </span>
                </div>
            ";
    }
    ?>
</div>