/*
 * 
 * Copyright (C) 2013 Tres Finocchiaro, QZ Industries
 * Copyright (C) 2013 Antoni Ten Monrós
 * 
 * IMPORTANT:  This software is dual-licensed
 * 
 * LGPL 2.1
 * This is free software.  This software and source code are released under 
 * the "LGPL 2.1 License".  A copy of this license should be distributed with 
 * this software. http://www.gnu.org/licenses/lgpl-2.1.html
 * 
 * QZ INDUSTRIES SOURCE CODE LICENSE
 * This software and source code *may* instead be distributed under the 
 * "QZ Industries Source Code License", available by request ONLY.  If source 
 * code for this project is to be made proprietary for an individual and/or a
 * commercial entity, written permission via a copy of the "QZ Industries Source
 * Code License" must be obtained first.  If you've obtained a copy of the 
 * proprietary license, the terms and conditions of the license apply only to 
 * the licensee identified in the agreement.  Only THEN may the LGPL 2.1 license
 * be voided.
 * 
 */
package jzebra;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.UnsupportedEncodingException;
import java.nio.charset.Charset;
import jzebra.exception.InvalidRawImageException;

/**
 * Abstract wrapper for images to be printed with thermal printers.
 *
 * @author Tres Finocchiaro
 * @author Antoni Ten Monrós
 *
 * Changelog: 
 * 
 * 20130805 (Tres Finocchiaro) Merged Antoni's changes with original keeping
 * Antoni's better instantiation, "black" pixel logic, removing class abstraction
 * (uses LanguageType Enum switching instead for smaller codebase)
 * 
 * 20130710 (Antoni Ten Monrós) Refactored the original, to have the
 * actual implementation of the different ImageWrapper classes in derived
 * classes, while leaving common functionality here.
 *
 */
public class ImageWrapper {

    /**
     * Represents the CHECK_BLACK quantization method, where only fully black
     * pixels are considered black when translating them to printer format.
     */
    public static final int CHECK_BLACK = 0;
    /**
     * Represents the CHECK_LUMA quantization method, pixels are considered
     * black if their luma is less than a set threshold. Transparent pixels, and
     * pixels whose alpha channel is less than the threshold are considered not
     * black.
     */
    public static final int CHECK_LUMA = 1;
    /**
     * Represents the CHECK_ALPHA quantization method, pixels are considered
     * black if their alpha is more than a set threshold. Color information is
     * discarded.
     */
    public static final int CHECK_ALPHA = 2;
    
    private int lumaThreshold = 127;
    private boolean[] imageAsBooleanArray;        //Image representation as an array of boolean, with true values representing imageAsBooleanArray dots
    private int[] imageAsIntArray;                //Image representation as an array of ints, with each bit representing a imageAsBooleanArray dot
    private ByteArrayBuilder byteBuffer = new ByteArrayBuilder();
    private int alphaThreshold = 127;
    private BufferedImage bufferedImage;
    private LanguageType languageType;
    private Charset charset = Charset.defaultCharset();
    private int imageQuantizationMethod = CHECK_LUMA;
    private int xPos = 0;   // X coordinate used for EPL2, CPCL.  Irrelevant for ZPLII, ESC/P, etc
    private int yPos = 0;   // Y coordinate used for EPL2, CPCL.  Irrelevant for ZPLII, ESC/P, etc

    /**
     * Creates a new
     * <code>ImageWrapper</code> from a
     * <code>BufferedImage.</code>
     *
     * @param bufferedImage The image to convert for thermal printing
     */
    public ImageWrapper(BufferedImage bufferedImage, LanguageType languageType) {
        this.bufferedImage = bufferedImage;
        this.languageType = languageType;
        LogIt.log("Loading BufferedImage");
        LogIt.log(
                "Dimensions: " + bufferedImage.getWidth() + "x" + bufferedImage.getHeight());
        init();
        
        if (languageType.requiresImageWidthValidated()) {
            validateImageWidth();
        }
    }

    /**
     * Returns the luma threshold used for the CHECK_LUMA quantization method.
     * Pixels that are more transparent than this, or that have a luma greater
     * than this will be considered white. The threshold goes from 0 (black) to
     * 255 (white).
     *
     * @return the current threshold
     */
    public int getLumaThreshold() {
        return lumaThreshold;
    }

    /**
     * Sets the luma threshold used for the CHECK_LUMA quantization method.
     * Pixels that are more transparent than this, or that have a luma greater
     * than this will be considered white. The threshold goes from 0 (black) to
     * 255 (white).
     *
     * @param lumaThreshold the threshold to set
     */
    public void setLumaThreshold(int lumaThreshold) {
        this.lumaThreshold = lumaThreshold;
    }

    /**
     * Get the method used to convert the image to monochrome. Currently
     * implemented methods are: <ul> <li><code>CHECK_BLACK</code>: Pixels are
     * considered black if and only if they are completely black and opaque
     * <li><code>CHECK_LUMA</code>: Pixels are considered black if and only if
     * their luma is under a threshold, and their opacity is over a threshold.
     * This threshold is set with
     * <code>setLumaThreshold</code> <li><code>CHECK_ALPHA</code>: Pixels are
     * considered black if and only if their opacity (alpha) is over a
     * threshold,. This threshold is set with
     * <code>setAlphaThreshold</code> </ul>
     *
     * Default quantization method is
     * <code>CHECK_BLACK</code>.
     *
     * @return the current quantization method
     */
    public int getImageQuantizationMethod() {
        return imageQuantizationMethod;
    }

    /**
     * Sets the method used to convert the image to monochrome. Currently
     * implemented methods are: <ul> <li><code>CHECK_BLACK</code>: Pixels are
     * considered black if and only if they are completely black and opaque
     * <li><code>CHECK_LUMA</code>: Pixels are considered black if and only if
     * their luma is under a threshold, and their opacity is over a threshold.
     * This threshold is set with
     * <code>setLumaThreshold</code> <li><code>CHECK_ALPHA</code>: Pixels are
     * considered black if and only if their opacity (alpha) is over a
     * threshold,. This threshold is set with
     * <code>setAlphaThreshold</code> </ul>
     *
     * Default (and fallback) quantization method is
     * <code>CHECK_BLACK</code>.
     *
     * @param imageQuantizationMethod the quantization method to set
     */
    public void setImageQuantizationMethod(int imageQuantizationMethod) {
        this.imageQuantizationMethod = imageQuantizationMethod;
    }

    /**
     * Returns the transparency (alpha) threshold used for the CHECK_ALPHA
     * quantization method. Pixels that are more transparent than this will be
     * considered white. The threshold goes from 0 (fully transparent) to 255
     * (fully opaque)
     *
     * @return the current threshold
     */
    public int getAlphaThreshold() {
        return alphaThreshold;
    }

    /**
     * Sets the transparency (alpha) threshold used for the CHECK_ALPHA
     * quantization method. Pixels that are more transparent than this will be
     * considered white. The threshold goes from 0 (fully transparent) to 255
     * (fully opaque)
     *
     * @param alphaThreshold the Threshold to set
     */
    public void setAlphaThreshold(int alphaThreshold) {
        this.alphaThreshold = alphaThreshold;
    }

    public int getxPos() {
        return xPos;
    }

    public void setxPos(int xPos) {
        this.xPos = xPos;
    }

    public int getyPos() {
        return yPos;
    }

    public void setyPos(int yPos) {
        this.yPos = yPos;
    }

    /**
     * Tests if a given pixel should be black. Multiple quantization algorythms
     * are available. The quantization method should be adjusted with
     * setQuantizationMethod. Should an invalied value be set as the
     * quantization method, CHECK_BLACK will be used
     *
     * @param rgbPixel the color of the pixel as defined in getRGB()
     * @return true if the pixel should be black, false otherwise
     */
    private boolean isBlack(int rgbPixel) {
        Color color = new Color(rgbPixel, true);

        int r = color.getRed();
        int g = color.getGreen();
        int b = color.getBlue();
        int a = color.getAlpha();
        switch (getImageQuantizationMethod()) {
            case CHECK_LUMA:
                if (a < getLumaThreshold()) {
                    return false;     // assume pixels that are less opaque than the luma threshold should be considered to be white
                }
                int luma = ((r * 299) + (g * 587) + (b * 114)) / 1000;      //luma formula
                return luma < getLumaThreshold();                   //pixels that have less luma than the threshold are black
            case CHECK_ALPHA:
                return a > getAlphaThreshold();         //pixels that are more opaque than the threshold are black
            case CHECK_BLACK:
                //only fully black pizels are black
            default:
                return color.equals(Color.BLACK);              //The default

        }
    }

    /**
     * Sets ImageAsBooleanArray. boolean is used instead of int for memory
     * considerations.
     *
     */
    private void generateBlackPixels() {
        LogIt.log("Converting image to monochrome");
        BufferedImage bi = bufferedImage;
        int h = bi.getHeight();
        int w = bi.getWidth();
        int[] rgbPixels = bi.getRGB(0, 0, w, h, null, 0, w);
        int i = 0;
        boolean[] pixels = new boolean[rgbPixels.length];
       /*
        * It makes most sense to have black pixels as 1's and white pixels
        * as zero's, however some printer manufacturers had this reversed
        * and used 0's for the black pixels.  EPL is a common language that
        * uses 0's for black pixels.
        * See also: https://support.zebra.com/cpws/docs/eltron/gw_command.htm
        */
        for (int rgbpixel : rgbPixels) {
            pixels[i++] = languageType.requiresImageOutputInverted() ? !isBlack(rgbpixel) : 
                    isBlack(rgbpixel);
        }
        setImageAsBooleanArray(pixels);
    }

    /**
     * Converts the internal representation of the image into an array of bytes,
     * suitable to be sent to a raw printer.
     *
     * @return The raw bytes that compose the image
     */
    private byte[] getBytes() {
        LogIt.log("Generating byte array");
        int[] ints = this.getImageAsIntArray();
        byte[] bytes = new byte[ints.length];
        for (int i = 0; i < ints.length; i++) {
            bytes[i] = (byte) ints[i];
        }
        return bytes;
    }

    private void generateIntArray() {
        LogIt.log("Packing bits");
        imageAsIntArray = new int[(int) (imageAsBooleanArray.length / 8)];
        // Convert every eight zero's to a full byte, in decimal
        for (int i = 0; i < imageAsIntArray.length; i++) {
            for (int k = 0; k < 8; k++) {
                imageAsIntArray[i] += (imageAsBooleanArray[8 * i + k] ? 1 : 0) << 7 - k;
            }
        }
    }

    /**
     * Generates the EPL2 commands to print an image. One command is emitted per
     * line of the image. This avoids issues with too long commands.
     *
     * @return The commands to print the image as an array of bytes, ready to be
     * sent to the printer
     */
    public byte[] getImageCommand() throws InvalidRawImageException, UnsupportedEncodingException {
        this.getByteBuffer().clear();
        
        switch (languageType) {
            case ESCP:
            case ESCP2:
                /* n1 and n2 represent the image height in 2-byte format
                   example: the number "09" would be "0009"
                            the number "10" would be "000A"
                            the number "255" would be "00FF"
                            the number "510" would be "FFFF"
                   Images larger than 510pixels must not be supported using ESC V syntax
                */
                int h = this.getHeight();
                if (h > 510) {
                    throw new InvalidRawImageException("ESC/P images taller than "
                            + "510 pixels are not supported using ESC V syntax.");
                }

                byte n1 = (byte)(h > 255 ? h - 255 : 0);
                byte n2 = (byte)(h <= 255 ? h : 255);
                
                this.getByteBuffer().append(new byte[]{0x1B,0x56,n1,n2}).append(getBytes());
                break;
            case ZPL:
            case ZPLII:
                String zplHexAsString = ByteUtilities.getHexString(getImageAsIntArray());
                int byteLen = zplHexAsString.length() / 2;
                int perRow = byteLen / getHeight();
                StringBuilder zpl = new StringBuilder("^GFA,")
                        .append(byteLen).append(",").append(byteLen).append(",")
                        .append(perRow).append(",").append(zplHexAsString);
                
                this.getByteBuffer().append(zpl, charset);
                break;
            case EPL:
            case EPL2:
                StringBuilder epl = new StringBuilder("GW")
                        .append(getxPos()).append(",")
                        .append(getyPos()).append(",")
                        .append(getWidth()/8).append(",")
                        .append(getHeight()).append(",");
                
                this.getByteBuffer().append(epl, charset).append(getBytes());
                break;
            case CPCL:
                String cpclHexAsString = ByteUtilities.getHexString(getImageAsIntArray());
                StringBuilder cpcl = new StringBuilder("EG ")
                        .append((int)(getWidth()/8)).append(" ")
                        .append(getHeight()).append(" ")
                        .append(getxPos()).append(" ")
                        .append(getyPos()).append(" ")
                        .append(cpclHexAsString);
                
                this.getByteBuffer().append(cpcl, charset);
                break;
            default:
                throw new InvalidRawImageException(charset.name() + " image conversion is not yet supported.");
        }
        return this.getByteBuffer().getByteArray();
    }

    /**
     * @return the width of the image
     */
    public int getWidth() {
        return this.bufferedImage.getWidth();
    }

    /**
     * @return the height of the image
     */
    public int getHeight() {
        return this.bufferedImage.getHeight();
    }

    /**
     * @return the image as an array of booleans
     */
    private boolean[] getImageAsBooleanArray() {
        return imageAsBooleanArray;
    }

    /**
     * @param imageAsBooleanArray the imageAsBooleanArray to set
     */
    private void setImageAsBooleanArray(boolean[] imageAsBooleanArray) {
        this.imageAsBooleanArray = imageAsBooleanArray;
    }

    /**
     * @return the imageAsIntArray
     */
    private int[] getImageAsIntArray() {
        return imageAsIntArray;
    }

    /**
     * @param imageAsIntArray the imageAsIntArray to set
     */
    private void setImageAsIntArray(int[] imageAsIntArray) {
        this.imageAsIntArray = imageAsIntArray;
    }

    /**
     * Initializes the ImageWrapper. This populates the internal structures with
     * the data created from the original image. It is normally called by the
     * constructor, but if for any reason you change the image contents (for
     * example, if you resize the image), it must be initialized again prior to
     * calling getImageCommand()
     */
    private final void init() {
        LogIt.log("Initializing Image Fields");
        generateBlackPixels();
        generateIntArray();
    }

    public Charset getCharset() {
        return charset;
    }

    public void setCharset(Charset charset) {
        this.charset = charset;
    }

    /**
     * @return the byteBuffer
     */
    private ByteArrayBuilder getByteBuffer() {
        return byteBuffer;
    }

    /**
     * @return the buffer
     */
    private BufferedImage getBufferedImage() {
        return bufferedImage;
    }

    /**
     * @param buffer the buffer to set
     */
    private void setBufferedImage(BufferedImage buffer) {
        this.bufferedImage = buffer;
    }
    
    /**
     * Checks if the image width is a multiple of 8, and if it's not, 
     * pads the image on the right side with blank pixels. <br />
     * Due to limitations on the EPL2 language, image widths must be a multiple 
     * of 8.
     */
    private void validateImageWidth()
    {
        BufferedImage oldBufferedImage = this.bufferedImage;
        int height=oldBufferedImage.getHeight();
        int width=oldBufferedImage.getWidth();
        if(width%8!=0) 
        {
            int newWidth=(width/8+1)*8;
            BufferedImage newBufferedImage=new BufferedImage(newWidth, height,
                    BufferedImage.TYPE_INT_ARGB);
            
            Graphics2D g = newBufferedImage.createGraphics();
            g.drawImage(oldBufferedImage, 0, 0, null);
            g.dispose();
            setBufferedImage(newBufferedImage);
            init();
       }
    }
}
