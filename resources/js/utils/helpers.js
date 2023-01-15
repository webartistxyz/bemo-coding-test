const nouns = ['dog', 'cat', 'tree', 'house', 'car', 'book'];
const verbs = ['ran', 'jumped', 'sat', 'stood', 'walked', 'read'];
const adverbs = ['quickly', 'slowly', 'gracefully', 'clumsily', 'noisily', 'happily'];

export function generateSentence() {
    const randomNoun = nouns[Math.floor(Math.random() * nouns.length)];
    const randomVerb = verbs[Math.floor(Math.random() * verbs.length)];
    const randomAdverb = adverbs[Math.floor(Math.random() * adverbs.length)];

    return `The ${randomNoun} ${randomVerb} ${randomAdverb}.`;
}
