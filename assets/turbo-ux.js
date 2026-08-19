/**
 * assets/turbo-ux.js
 *
 * Petites retouches UX qui s'appuient sur Turbo Drive (déjà activé via
 * assets/controllers.json) pour rendre la navigation et les formulaires
 * plus fluides, sans dépendance supplémentaire :
 *
 * 1. Un léger fondu pendant qu'une nouvelle page se charge, plutôt qu'un
 *    changement brut d'un écran à l'autre.
 * 2. Un état "chargement" sur le bouton de n'importe quel formulaire au
 *    moment du submit, pour éviter le double-clic et donner un retour
 *    visuel immédiat (utile surtout sur les formulaires admin/CRUD).
 */

// --- 1. Fondu pendant la navigation Turbo ---
document.addEventListener("turbo:before-visit", () => {
  document.documentElement.classList.add("turbo-fade-out");
});

document.addEventListener("turbo:render", () => {
  document.documentElement.classList.remove("turbo-fade-out");
});

// --- 2. État de chargement sur les boutons de formulaire ---
document.addEventListener("submit", (event) => {
  const form = event.target;
  if (!(form instanceof HTMLFormElement)) {
    return;
  }

  const submitter = event.submitter;
  if (!submitter || submitter.disabled) {
    return;
  }

  submitter.classList.add("is-loading");
  submitter.disabled = true;
});

// Si Turbo annule/échoue la soumission (erreur réseau, etc.), on
// réactive le bouton pour ne pas bloquer l'utilisateur.
document.addEventListener("turbo:submit-end", (event) => {
  if (!event.detail.success) {
    const submitter = event.target.querySelector(".is-loading");
    if (submitter) {
      submitter.classList.remove("is-loading");
      submitter.disabled = false;
    }
  }
});
