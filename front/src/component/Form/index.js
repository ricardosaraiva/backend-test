import React from 'react';


import { 
  Container, 
  Label, 
  Input as InputElement,
  ButtonSubmit 
} from './styles';

const Input = function Input(props) {
  return (
    <Container {...props.container}>
        <Label htmlFor={props.id}>{props.label}</Label>
        <InputElement id={props.id}/>
    </Container>
  );
}

const InputFile = function InputFile(props) {
  return (
    <Container {...props.container}>
        <Label htmlFor={props.id}>{props.label}</Label>
        <InputElement id={props.id} type="file"/>
    </Container>
  );
}

export default function Form(props) {
  return (
    <form {...props}>
        {props.children}
    </form>
  );
}

export {Input, InputFile, ButtonSubmit};