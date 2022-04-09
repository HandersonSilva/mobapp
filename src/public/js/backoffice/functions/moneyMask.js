export default inputs => {
   inputs.forEach(input => {
       // Masking input element to money with options.
       VMasker(input.input).maskMoney({
           // Decimal precision -> "90"
           precision: input.params[0],
           // Decimal separator -> ",90"
           separator: input.params[1],
           // Number delimiter -> "12.345.678"
           delimiter: input.params[2],
           // Money unit -> "R$ 12.345.678,90"
           unit: input.params[3],
           // Force type only number instead decimal,
           // masking decimals with ",00"
           // Zero cents -> "R$ 1.234.567.890,00"
           zeroCents: input.params[4]
       });
       
   });
    
};
