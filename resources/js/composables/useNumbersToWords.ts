// composables/useNumberToWords.ts
export function useNumberToWords() {
  const ones = [
    '',
    'One',
    'Two',
    'Three',
    'Four',
    'Five',
    'Six',
    'Seven',
    'Eight',
    'Nine',
    'Ten',
    'Eleven',
    'Twelve',
    'Thirteen',
    'Fourteen',
    'Fifteen',
    'Sixteen',
    'Seventeen',
    'Eighteen',
    'Nineteen',
  ]

  const tens = [
    '',
    '',
    'Twenty',
    'Thirty',
    'Forty',
    'Fifty',
    'Sixty',
    'Seventy',
    'Eighty',
    'Ninety',
  ]

  function convertHundreds(num: number): string {
    let str = ''
    if (num > 99) {
      str += `${ones[Math.floor(num / 100)]} Hundred `
      num = num % 100
    }
    if (num > 19) {
      str += `${tens[Math.floor(num / 10)]} `
      num = num % 10
    }
    if (num > 0) {
      str += `${ones[num]} `
    }
    return str.trim()
  }

  function numberToWords(num: number): string {
    if (num === 0)
      return 'Zero'

    let result = ''
    const scales = ['', 'Thousand', 'Million', 'Billion']
    let scaleIndex = 0

    while (num > 0) {
      const chunk = num % 1000
      if (chunk) {
        result = `${convertHundreds(chunk)} ${scales[scaleIndex]} ${result}`.trim()
      }
      num = Math.floor(num / 1000)
      scaleIndex++
    }

    return result.trim()
  }

  function numberToCurrencyWords(num: number): string {
    if (num === 0) {
      return 'Kenya Shillings Zero Only'
    }

    return ` ${numberToWords(num)} Kenya Shillings Only`
  }

  return { numberToWords, numberToCurrencyWords }
}
