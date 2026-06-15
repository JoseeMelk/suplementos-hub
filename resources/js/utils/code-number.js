export function separateCodeNumber(code, prefix = 'SUP') {
  const value = String(code).replace(/\s+/g, '').toUpperCase();

  const part1 = value.slice(0, 3);
  const part2 = value.slice(3, 6);
  const part3 = value.slice(6, 10);

  return `${prefix}-${part1}-${part2}-${part3}`;
}