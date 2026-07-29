export function lockPage() {
  console.log("Locking page");
  // 1. hide overflow
  document.documentElement.style.overflow = 'hidden';
  // 2. block wheel / touch gestures
  const blocker = e => e.preventDefault();
  window.addEventListener('wheel', blocker, { passive: false });
  window.addEventListener('touchmove', blocker, { passive: false });
  // 3. block scroll‑related keys
  const keyBlocker = e => {
    const keys = ['ArrowUp','ArrowDown','PageUp','PageDown','Space'];
    if (keys.includes(e.key)) e.preventDefault();
  };
  window.addEventListener('keydown', keyBlocker);
  // store references to remove later
  return () => {
    document.documentElement.style.overflow = '';
    window.removeEventListener('wheel', blocker);
    window.removeEventListener('touchmove', blocker);
    window.removeEventListener('keydown', keyBlocker);
  };
}
