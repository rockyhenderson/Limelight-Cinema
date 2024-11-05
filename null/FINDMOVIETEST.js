//THIS IS TO COPY INTO CONSOLE DO NOT RUN OR LINK THIS TO ANYTHING ELSE!!!!!!!!!!!!!!!!!!!!!!!!!!

function pickRandomMovie() {
    const movieItems = document.querySelectorAll('.movie-item');
    if (movieItems.length > 0) {
        const randomIndex = Math.floor(Math.random() * movieItems.length);
        const randomMovie = movieItems[randomIndex];
        console.log(`Random Movie: ${randomMovie.querySelector('h2').innerText}`);
        randomMovie.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        console.log("No movies found.");
    }
}

pickRandomMovie();
