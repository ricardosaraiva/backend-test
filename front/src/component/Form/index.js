import React from 'react';


import { 
  Container, 
  Label, 
  Input as InputElement,
  InputMask as InputMaskElement,
  ButtonSubmit 
} from './styles';

const Input = function Input(props) {
  return (
    <Container {...props.container}>
        <Label htmlFor={props.id}>{props.label}</Label>
        <InputElement id={props.id} name={props.id} {...props.input} />
    </Container>
  );
}

const InputMask = function Input(props) {
  return (
    <Container {...props.container}>
        <Label htmlFor={props.id}>{props.label}</Label>
        <InputMaskElement id={props.id} name={props.id} {...props.input} mask={props.mask} />
    </Container>
  );
}

const InputFile = function InputFile(props) {
  return (
    <Container {...props.container}>
        <Label htmlFor={props.id}>{props.label}</Label>
        <InputElement id={props.id} type="file" {...props.input} />
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

export {Input, InputMask, InputFile, ButtonSubmit};