let HOST_URL = "https://mmi.unilim.fr/~pinardel2/SAE2.03-Pinardel";

let DataProfile = {};

DataProfile.read = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readProfiles");
  let profile = await answer.json();
  return profile;
  
};

export { DataProfile };