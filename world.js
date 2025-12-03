document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.querySelector('#lookup'); 
    const lookupCitiesButton = document.querySelector('#lookup-cities'); 
    const resultArea = document.querySelector('#result'); 
    const countryInput = document.querySelector('#country'); 
   
    const fetchData = (url) => {
        console.log(`Fetching data from: ${url}`); 
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text(); 
            })
            .then(data => {
                console.log("Response received:", data); 
                resultArea.innerHTML = data; 
            })
            .catch(error => {
                console.error('Fetch error:', error); 
                resultArea.innerHTML = '<p>Error fetching data. Please try again.</p>';
            });
    };

   
    lookupButton.addEventListener('click', (event) => {
        event.preventDefault();
        const country = countryInput.value.trim(); 
        if (!country) {
            resultArea.innerHTML = '<p>Please enter a country name.</p>';
            return;
        }
        const url = `world.php?country=${encodeURIComponent(country)}`;
        fetchData(url);
    });

    
    lookupCitiesButton.addEventListener('click', (event) => {
        event.preventDefault();
        const country = countryInput.value.trim(); 
        if (!country) {
            resultArea.innerHTML = '<p>Please enter a country name.</p>';
            return;
        }
        const url = `world.php?country=${encodeURIComponent(country)}&context=cities`;
        fetchData(url);
    });
});
