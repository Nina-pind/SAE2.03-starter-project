let HOST_URL = "https://mmi.unilim.fr/~pinardel2/SAE2.03-Pinardel";

let DataFilm = {}; 

DataFilm.requestFilms = async function () { 
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addFilm"); 
  let data = await answer.json();
  return data;
};

export { DataFilm }; 