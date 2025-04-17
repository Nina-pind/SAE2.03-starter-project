let HOST_URL = "../server";

let DataComment = {};


DataComment.getPendingComments = async function () {
  const url = `${HOST_URL}/script.php?todo=getPendingComments`;
  let answer = await fetch(url);
  if (!answer.ok) {
    console.error("Erreur lors de la récupération des commentaires en attente.");
    return [];
  }
  let comments = await answer.json();
  return comments;
};

DataComment.approveComment = async function (commentId) {
  const url = `${HOST_URL}/script.php?todo=approveComment`;
  let config = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `comment_id=${commentId}`,
  };
  let answer = await fetch(url, config);
  if (!answer.ok) {
    console.error("Erreur lors de l'approbation du commentaire.");
    return "Erreur lors de l'approbation.";
  }
  let response = await answer.json();
  return response;
};

DataComment.deleteComment = async function (commentId) {
  const url = `${HOST_URL}/script.php?todo=deleteComment`;
  let config = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `comment_id=${commentId}`,
  };
  let answer = await fetch(url, config);
  if (!answer.ok) {
    console.error("Erreur lors de la suppression du commentaire.");
    return "Erreur lors de la suppression.";
  }
  let response = await answer.json();
  return response;
};

export { DataComment };