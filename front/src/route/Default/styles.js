import styled from 'styled-components';

const Container = styled.nav`
  background-color: var(--primary-color) !important;  
  position: fixed;
  width: 100%;
  margin: 0;
  color: #FFF;
  display: block;
  clear: both;
  z-index: 100;
`;

const BrandContainer = styled.div`
  padding-top: 3px;
  float: left;
  font-size: 30px;
`;
const BrandIcon = styled.i`
  margin-right: 10px;
`;

const BrandText = styled.span`
  font-size: 80%;
`;

const ContainerButton = styled.div`
  float: right;
`;

const Button = styled.button`
  margin: 8px 10px;  
`;

Container.defaultProps = {
  className: 'navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow'
};

BrandContainer.defaultProps = {
  className: 'd-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100'
};

Button.defaultProps = {
  className: 'btn btn-success'
};

export {
  Container,
  BrandContainer,
  BrandIcon,
  BrandText,
  ContainerButton,
  Button
}